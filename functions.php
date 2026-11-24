<?php
/**
 * 1776 theme bootstrap.
 *
 * This file stays deliberately small. Each concern lives in its own file
 * under inc/ so a reviewer (or future maintainer) can find things quickly:
 *
 * - inc/setup.php              Theme supports, block styles, editor styles.
 * - inc/enqueue.php            Front-end assets and per-block CSS loading.
 * - inc/post-types.php         Project and Message post types, taxonomy, meta.
 * - inc/meta-boxes.php         "Project details" meta box (client, year, URL).
 * - inc/blocks.php             Registers the custom blocks in blocks/.
 * - inc/patterns.php           Block pattern categories.
 * - inc/contact-form.php       Secure handler for the contact form block.
 * - inc/template-functions.php Small helpers shared by blocks and patterns.
 *
 * All PHP is namespaced under Theme1776 so nothing leaks into the global
 * function namespace.
 *
 * @package Theme1776
 */

defined( 'ABSPATH' ) || exit;

define( 'THEME_1776_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );
define( 'THEME_1776_DIR', get_template_directory() );
define( 'THEME_1776_URI', get_template_directory_uri() );

foreach ( array( 'setup', 'enqueue', 'template-functions', 'post-types', 'meta-boxes', 'blocks', 'patterns', 'contact-form' ) as $theme_1776_file ) {
	require_once THEME_1776_DIR . '/inc/' . $theme_1776_file . '.php';
}
unset( $theme_1776_file );
