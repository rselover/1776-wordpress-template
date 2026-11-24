<?php
/**
 * Server render for theme-1776/contact-form.
 *
 * Plain HTML form that posts to admin-post.php; see inc/contact-form.php
 * for the handler. Works with JavaScript disabled.
 *
 * @package Theme1776
 *
 * @var array<string, mixed> $attributes Block attributes.
 */

use Theme1776\ContactForm;

defined( 'ABSPATH' ) || exit;

$theme_1776_status = ContactForm\current_status();
$theme_1776_label  = trim( (string) $attributes['submitLabel'] );
$theme_1776_label  = '' !== $theme_1776_label ? $theme_1776_label : __( 'Send message', '1776-wordpress-template' );
$theme_1776_here   = get_permalink() ? get_permalink() : home_url( '/' );
?>
<div <?php echo get_block_wrapper_attributes( array( 'id' => ContactForm\FORM_ANCHOR ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>>
	<?php if ( $theme_1776_status ) : ?>
		<p class="t1776-form__notice is-<?php echo esc_attr( $theme_1776_status['type'] ); ?>" role="<?php echo 'error' === $theme_1776_status['type'] ? 'alert' : 'status'; ?>">
			<?php echo esc_html( $theme_1776_status['text'] ); ?>
		</p>
	<?php endif; ?>

	<form class="t1776-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="<?php echo esc_attr( ContactForm\ACTION ); ?>">
		<input type="hidden" name="t1776_redirect" value="<?php echo esc_url( $theme_1776_here ); ?>">
		<?php wp_nonce_field( ContactForm\ACTION, ContactForm\NONCE_FIELD, false ); ?>

		<p class="t1776-form__field">
			<label for="t1776-name"><?php esc_html_e( 'Name', '1776-wordpress-template' ); ?></label>
			<input type="text" id="t1776-name" name="t1776_name" autocomplete="name" required maxlength="<?php echo esc_attr( ContactForm\MAX_NAME ); ?>">
		</p>

		<p class="t1776-form__field">
			<label for="t1776-email"><?php esc_html_e( 'Email', '1776-wordpress-template' ); ?></label>
			<input type="email" id="t1776-email" name="t1776_email" autocomplete="email" required>
		</p>

		<p class="t1776-form__field">
			<label for="t1776-message"><?php esc_html_e( 'How can we help?', '1776-wordpress-template' ); ?></label>
			<textarea id="t1776-message" name="t1776_message" rows="6" required maxlength="<?php echo esc_attr( ContactForm\MAX_MESSAGE ); ?>"></textarea>
		</p>

		<?php /* Honeypot: hidden from people and screen readers, tempting to bots. */ ?>
		<p class="t1776-form__hp" aria-hidden="true">
			<label for="t1776-website"><?php esc_html_e( 'Leave this field empty', '1776-wordpress-template' ); ?></label>
			<input type="text" id="t1776-website" name="<?php echo esc_attr( ContactForm\HONEYPOT ); ?>" tabindex="-1" autocomplete="off">
		</p>

		<p class="t1776-form__actions wp-block-button">
			<button type="submit" class="wp-block-button__link wp-element-button"><?php echo esc_html( $theme_1776_label ); ?></button>
		</p>
	</form>
</div>
