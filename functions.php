<?php
/**
 * Theme setup.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( '1776-wordpress-template', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
} );
