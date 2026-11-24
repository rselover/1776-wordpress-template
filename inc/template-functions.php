<?php
/**
 * Small helpers shared by blocks, patterns and the contact form.
 *
 * @package Theme1776
 */

namespace Theme1776;

defined( 'ABSPATH' ) || exit;

/**
 * Project post type slug. Prefixed to avoid clashing with plugins.
 */
const PROJECT_POST_TYPE = 't1776_project';

/**
 * Project type taxonomy slug.
 */
const PROJECT_TAXONOMY = 't1776_project_type';

/**
 * Contact message post type slug.
 */
const MESSAGE_POST_TYPE = 't1776_message';

/**
 * Project meta keys and their human labels.
 *
 * Single source of truth used by meta registration, the meta box and the
 * Project Details block.
 *
 * @return array<string, string> Meta key => label.
 */
function project_meta_fields() {
	return array(
		't1776_client' => __( 'Client', '1776-wordpress-template' ),
		't1776_year'   => __( 'Year', '1776-wordpress-template' ),
		't1776_url'    => __( 'Live site', '1776-wordpress-template' ),
	);
}

/**
 * Get a project's details, already sanitized for output contexts.
 *
 * @param int $post_id Project post ID.
 * @return array{client: string, year: string, url: string}
 */
function get_project_details( $post_id ) {
	return array(
		'client' => (string) get_post_meta( $post_id, 't1776_client', true ),
		'year'   => (string) get_post_meta( $post_id, 't1776_year', true ),
		'url'    => (string) get_post_meta( $post_id, 't1776_url', true ),
	);
}

/**
 * Sanitize a four-digit year. Returns an empty string when invalid.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function sanitize_year( $value ) {
	$value = preg_replace( '/\D/', '', (string) $value );
	$year  = (int) $value;

	return ( $year >= 1776 && $year <= 2100 ) ? (string) $year : '';
}
