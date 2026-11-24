<?php
/**
 * Front-end assets.
 *
 * @package Theme1776
 */

namespace Theme1776\Enqueue;

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the main stylesheet.
 *
 * Version comes from the theme header so browsers re-fetch after an update.
 *
 * @return void
 */
function enqueue_styles() {
	wp_enqueue_style(
		'theme-1776',
		get_stylesheet_uri(),
		array(),
		THEME_1776_VERSION
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_styles' );

/**
 * Load per-block CSS for core blocks only when the block is on the page.
 *
 * Drop a file named after the block (e.g. core-navigation.css for
 * core/navigation) into assets/css/blocks/ and it is picked up here.
 * wp_enqueue_block_style() attaches it to the block's own stylesheet, so it
 * is printed only on pages that render that block, and inlined when small.
 *
 * @return void
 */
function enqueue_block_styles() {
	$files = glob( THEME_1776_DIR . '/assets/css/blocks/core-*.css' );

	if ( ! $files ) {
		return;
	}

	foreach ( $files as $file ) {
		$slug       = basename( $file, '.css' );
		$block_name = 'core/' . substr( $slug, strlen( 'core-' ) );

		wp_enqueue_block_style(
			$block_name,
			array(
				'handle' => 'theme-1776-' . $slug,
				'src'    => THEME_1776_URI . '/assets/css/blocks/' . $slug . '.css',
				'path'   => $file,
				'ver'    => THEME_1776_VERSION,
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\enqueue_block_styles' );
