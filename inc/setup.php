<?php
/**
 * Theme setup: supports, editor styles and block style variations.
 *
 * @package Theme1776
 */

namespace Theme1776\Setup;

defined( 'ABSPATH' ) || exit;

/**
 * Declare theme supports.
 *
 * Block themes get most supports automatically (title-tag, html5, feeds,
 * responsive embeds...). We only add what is not on by default, and opt out
 * of the remote core pattern library so the inserter shows this theme's own
 * curated patterns.
 *
 * @return void
 */
function theme_supports() {
	load_theme_textdomain( '1776-wordpress-template', THEME_1776_DIR . '/languages' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );

	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_supports' );

/**
 * Register block style variations used by the theme's patterns.
 *
 * The CSS for each lives in style.css, which is loaded in both the editor
 * and the front end, so no inline_style is needed here.
 *
 * @return void
 */
function register_block_styles() {
	$styles = array(
		'core/group'     => array(
			'card' => __( 'Card', '1776-wordpress-template' ),
		),
		'core/list'      => array(
			'stars' => __( 'Stars', '1776-wordpress-template' ),
		),
		'core/separator' => array(
			'stars' => __( 'Stars', '1776-wordpress-template' ),
		),
		'core/paragraph' => array(
			'eyebrow' => __( 'Eyebrow', '1776-wordpress-template' ),
		),
	);

	foreach ( $styles as $block => $variations ) {
		foreach ( $variations as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block_styles' );

/**
 * Shorter, cleaner excerpts for cards and archive lists.
 *
 * @return int Number of words.
 */
function excerpt_length() {
	return 28;
}
add_filter( 'excerpt_length', __NAMESPACE__ . '\excerpt_length' );

/**
 * Replace the default "[...]" excerpt suffix with a plain ellipsis.
 *
 * @return string
 */
function excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', __NAMESPACE__ . '\excerpt_more' );
