<?php
/**
 * Contact form handler for the theme-1776/contact-form block.
 *
 * The form posts to admin-post.php, so it works without JavaScript and
 * without a plugin. Defence in depth, in order:
 *
 * 1. Nonce check (CSRF).
 * 2. Honeypot field (cheap bot filter; bots are told "sent" and ignored).
 * 3. Rate limit per visitor (hashed IP, never stored raw).
 * 4. Validation and sanitization of every field.
 * 5. The message is saved as a private "Message" post first, then emailed,
 *    so a mail failure never loses a lead.
 * 6. Redirect back with a whitelisted status code (Post/Redirect/Get).
 *
 * @package Theme1776
 */

namespace Theme1776\ContactForm;

use const Theme1776\MESSAGE_POST_TYPE;

defined( 'ABSPATH' ) || exit;

const ACTION      = 't1776_contact';
const NONCE_FIELD = 't1776_contact_nonce';
const HONEYPOT    = 't1776_website';
const QUERY_ARG   = 'contact';
const RATE_LIMIT  = 3;
const RATE_WINDOW = 10 * MINUTE_IN_SECONDS;
const MAX_NAME    = 100;
const MAX_MESSAGE = 5000;
const FORM_ANCHOR = 't1776-contact';

/**
 * Status codes and the message shown to the visitor for each.
 *
 * @return array<string, array{type: string, text: string}>
 */
function statuses() {
	return array(
		'sent'    => array(
			'type' => 'success',
			'text' => __( 'Thanks! Your message has been sent. We usually reply within one business day.', '1776-wordpress-template' ),
		),
		'invalid' => array(
			'type' => 'error',
			'text' => __( 'Please fill in your name, a valid email address and a message.', '1776-wordpress-template' ),
		),
		'expired' => array(
			'type' => 'error',
			'text' => __( 'Your session expired. Please reload the page and try again.', '1776-wordpress-template' ),
		),
		'limited' => array(
			'type' => 'error',
			'text' => __( 'Too many messages in a short time. Please wait a few minutes and try again.', '1776-wordpress-template' ),
		),
		'error'   => array(
			'type' => 'error',
			'text' => __( 'Something went wrong while sending. Please try again later.', '1776-wordpress-template' ),
		),
	);
}

/**
 * Read the status code from the URL after a redirect.
 *
 * Only known codes are accepted, so nothing user-controlled reaches output.
 *
 * @return array{type: string, text: string}|null
 */
function current_status() {
	// Display-only flag set by our own redirect; whitelisted below, no state change.
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$code = isset( $_GET[ QUERY_ARG ] ) ? sanitize_key( wp_unslash( $_GET[ QUERY_ARG ] ) ) : '';

	$statuses = statuses();

	return isset( $statuses[ $code ] ) ? $statuses[ $code ] : null;
}

/**
 * Handle a form submission.
 *
 * Hooked to both logged-in and logged-out admin-post actions.
 *
 * @return void
 */
function handle_submission() {
	$redirect = get_redirect_url();

	$nonce = isset( $_POST[ NONCE_FIELD ] ) ? sanitize_text_field( wp_unslash( $_POST[ NONCE_FIELD ] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, ACTION ) ) {
		redirect_with_status( $redirect, 'expired' );
	}

	// Honeypot: humans never see this field. Pretend success so bots move on.
	if ( ! empty( $_POST[ HONEYPOT ] ) ) {
		redirect_with_status( $redirect, 'sent' );
	}

	if ( is_rate_limited() ) {
		redirect_with_status( $redirect, 'limited' );
	}

	$name    = isset( $_POST['t1776_name'] ) ? sanitize_text_field( wp_unslash( $_POST['t1776_name'] ) ) : '';
	$email   = isset( $_POST['t1776_email'] ) ? sanitize_email( wp_unslash( $_POST['t1776_email'] ) ) : '';
	$message = isset( $_POST['t1776_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['t1776_message'] ) ) : '';

	if (
		'' === $name || mb_strlen( $name ) > MAX_NAME ||
		! is_email( $email ) ||
		'' === $message || mb_strlen( $message ) > MAX_MESSAGE
	) {
		redirect_with_status( $redirect, 'invalid' );
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => MESSAGE_POST_TYPE,
			'post_status'  => 'publish',
			/* translators: %s: sender name. */
			'post_title'   => sprintf( __( 'Message from %s', '1776-wordpress-template' ), $name ),
			'post_content' => $message,
			'meta_input'   => array(
				't1776_name'  => $name,
				't1776_email' => $email,
			),
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		redirect_with_status( $redirect, 'error' );
	}

	send_notification( $name, $email, $message, $post_id );

	redirect_with_status( $redirect, 'sent' );
}
add_action( 'admin_post_' . ACTION, __NAMESPACE__ . '\handle_submission' );
add_action( 'admin_post_nopriv_' . ACTION, __NAMESPACE__ . '\handle_submission' );

/**
 * Email the site owner about a new message.
 *
 * Delivery is best effort: the message is already stored, so a failed
 * wp_mail() (common on dev hosts) is not reported to the visitor as an error.
 *
 * @param string $name    Sender name (sanitized, no line breaks).
 * @param string $email   Sender email (validated).
 * @param string $message Message body (sanitized).
 * @param int    $post_id Stored message ID.
 * @return bool Whether wp_mail() accepted the message.
 */
function send_notification( $name, $email, $message, $post_id ) {
	/**
	 * Filter who receives contact form notifications.
	 *
	 * @param string $recipient Email address. Defaults to the site admin email.
	 */
	$recipient = apply_filters( 'theme_1776_contact_recipient', get_option( 'admin_email' ) );

	$subject = sprintf(
		/* translators: 1: site name, 2: sender name. */
		__( '[%1$s] New message from %2$s', '1776-wordpress-template' ),
		wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		$name
	);

	$body = sprintf(
		"%s\n\n%s: %s <%s>\n%s: %s\n",
		$message,
		__( 'From', '1776-wordpress-template' ),
		$name,
		$email,
		__( 'View in admin', '1776-wordpress-template' ),
		admin_url( 'post.php?post=' . absint( $post_id ) . '&action=edit' )
	);

	// $name has no line breaks (sanitize_text_field) and $email is validated, so the header is safe.
	$headers = array( sprintf( 'Reply-To: %s <%s>', $name, $email ) );

	return wp_mail( $recipient, $subject, $body, $headers );
}

/**
 * Allow a few submissions per visitor per window.
 *
 * The visitor key is a keyed hash of their IP, so raw IPs are never stored.
 *
 * @return bool True when the visitor is over the limit.
 */
function is_rate_limited() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

	if ( '' === $ip ) {
		return false;
	}

	$key   = 't1776_contact_' . substr( wp_hash( $ip ), 0, 20 );
	$count = (int) get_transient( $key );

	if ( $count >= RATE_LIMIT ) {
		return true;
	}

	set_transient( $key, $count + 1, RATE_WINDOW );

	return false;
}

/**
 * Where to send the visitor after submitting: back to the form's page.
 *
 * Off-site URLs are rejected by wp_validate_redirect() (open redirect protection).
 *
 * @return string
 */
function get_redirect_url() {
	$raw = isset( $_POST['t1776_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['t1776_redirect'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Read before the nonce check so even a failed check can redirect back.

	return wp_validate_redirect( $raw, home_url( '/' ) );
}

/**
 * Redirect back to the form with a status code and stop.
 *
 * @param string $url    Validated redirect URL.
 * @param string $status Status code from statuses().
 * @return void
 */
function redirect_with_status( $url, $status ) {
	$url = remove_query_arg( QUERY_ARG, $url );
	$url = add_query_arg( QUERY_ARG, $status, $url ) . '#' . FORM_ANCHOR;

	wp_safe_redirect( $url, 303 );
	exit;
}
