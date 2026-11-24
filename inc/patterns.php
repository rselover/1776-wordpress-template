<?php
/**
 * Block pattern categories.
 *
 * Patterns themselves live in patterns/*.php and are registered
 * automatically by WordPress from their file headers. They are PHP (not
 * static HTML) so every string is translatable and every URL is escaped.
 *
 * @package Theme1776
 */

namespace Theme1776\Patterns;

defined( 'ABSPATH' ) || exit;

/**
 * Register the theme's pattern categories.
 *
 * @return void
 */
function register_pattern_categories() {
	register_block_pattern_category(
		'theme-1776',
		array(
			'label'       => __( '1776', '1776-wordpress-template' ),
			'description' => __( 'Sections designed for the 1776 theme.', '1776-wordpress-template' ),
		)
	);

	register_block_pattern_category(
		'theme-1776-pages',
		array(
			'label'       => __( '1776 full pages', '1776-wordpress-template' ),
			'description' => __( 'Complete page layouts for the 1776 theme.', '1776-wordpress-template' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_pattern_categories' );
