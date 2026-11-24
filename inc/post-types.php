<?php
/**
 * Content model: Projects (portfolio), Project Types and contact Messages.
 *
 * Note for reviewers: WordPress.org guidelines put post types in plugins so
 * content survives a theme switch. For a client build I would move this file
 * into a small functionality plugin; it lives here so the demo is a single
 * install. Everything is prefixed (t1776_) and self-contained to make that
 * move a copy-and-paste job.
 *
 * @package Theme1776
 */

namespace Theme1776\PostTypes;

use function Theme1776\project_meta_fields;
use const Theme1776\MESSAGE_POST_TYPE;
use const Theme1776\PROJECT_POST_TYPE;
use const Theme1776\PROJECT_TAXONOMY;

defined( 'ABSPATH' ) || exit;

/**
 * Register the Project post type.
 *
 * @return void
 */
function register_project_post_type() {
	register_post_type(
		PROJECT_POST_TYPE,
		array(
			'labels'        => array(
				'name'               => __( 'Projects', '1776-wordpress-template' ),
				'singular_name'      => __( 'Project', '1776-wordpress-template' ),
				'add_new_item'       => __( 'Add New Project', '1776-wordpress-template' ),
				'edit_item'          => __( 'Edit Project', '1776-wordpress-template' ),
				'new_item'           => __( 'New Project', '1776-wordpress-template' ),
				'view_item'          => __( 'View Project', '1776-wordpress-template' ),
				'search_items'       => __( 'Search Projects', '1776-wordpress-template' ),
				'not_found'          => __( 'No projects found.', '1776-wordpress-template' ),
				'not_found_in_trash' => __( 'No projects found in Trash.', '1776-wordpress-template' ),
				'all_items'          => __( 'All Projects', '1776-wordpress-template' ),
				'archives'           => __( 'Project Archives', '1776-wordpress-template' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'has_archive'   => 'projects',
			'rewrite'       => array(
				'slug'       => 'projects',
				'with_front' => false,
			),
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
			'template'      => array(
				array(
					'core/paragraph',
					array( 'placeholder' => __( 'What was the challenge, and what did you build?', '1776-wordpress-template' ) ),
				),
			),
		)
	);

	register_taxonomy(
		PROJECT_TAXONOMY,
		PROJECT_POST_TYPE,
		array(
			'labels'            => array(
				'name'          => __( 'Project Types', '1776-wordpress-template' ),
				'singular_name' => __( 'Project Type', '1776-wordpress-template' ),
				'all_items'     => __( 'All Project Types', '1776-wordpress-template' ),
				'edit_item'     => __( 'Edit Project Type', '1776-wordpress-template' ),
				'add_new_item'  => __( 'Add New Project Type', '1776-wordpress-template' ),
			),
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'project-type',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_project_post_type' );

/**
 * Register project meta so it is typed, sanitized and available in REST.
 *
 * @return void
 */
function register_project_meta() {
	$sanitizers = array(
		't1776_client' => 'sanitize_text_field',
		't1776_year'   => 'Theme1776\sanitize_year',
		't1776_url'    => 'esc_url_raw',
	);

	foreach ( project_meta_fields() as $key => $label ) {
		register_post_meta(
			PROJECT_POST_TYPE,
			$key,
			array(
				'type'              => 'string',
				'description'       => $label,
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => true,
				'sanitize_callback' => $sanitizers[ $key ],
				'auth_callback'     => static function ( $allowed, $meta_key, $post_id ) {
					return current_user_can( 'edit_post', $post_id );
				},
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\register_project_meta' );

/**
 * Register the private Message post type that stores contact submissions.
 *
 * Messages are saved even if email delivery fails, so no lead is lost. They
 * are never public, and nobody can create one from the admin: they only come
 * in through the contact form handler.
 *
 * @return void
 */
function register_message_post_type() {
	register_post_type(
		MESSAGE_POST_TYPE,
		array(
			'labels'              => array(
				'name'          => __( 'Messages', '1776-wordpress-template' ),
				'singular_name' => __( 'Message', '1776-wordpress-template' ),
				'edit_item'     => __( 'View Message', '1776-wordpress-template' ),
				'all_items'     => __( 'All Messages', '1776-wordpress-template' ),
				'not_found'     => __( 'No messages yet.', '1776-wordpress-template' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 26,
			'supports'            => array( 'title', 'editor' ),
			'capability_type'     => 'post',
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_message_post_type' );

/**
 * Show who sent each message in the admin list.
 *
 * @param array<string, string> $columns Existing columns.
 * @return array<string, string>
 */
function message_columns( $columns ) {
	$date = $columns['date'];
	unset( $columns['date'] );

	$columns['t1776_from'] = __( 'From', '1776-wordpress-template' );
	$columns['date']       = $date;

	return $columns;
}
add_filter( 'manage_' . MESSAGE_POST_TYPE . '_posts_columns', __NAMESPACE__ . '\message_columns' );

/**
 * Render the "From" column.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 * @return void
 */
function message_column_content( $column, $post_id ) {
	if ( 't1776_from' !== $column ) {
		return;
	}

	$name  = get_post_meta( $post_id, 't1776_name', true );
	$email = get_post_meta( $post_id, 't1776_email', true );

	printf(
		'%1$s<br><a href="%2$s">%3$s</a>',
		esc_html( $name ),
		esc_url( 'mailto:' . $email ),
		esc_html( $email )
	);
}
add_action( 'manage_' . MESSAGE_POST_TYPE . '_posts_custom_column', __NAMESPACE__ . '\message_column_content', 10, 2 );

/**
 * Flush rewrite rules once when the theme is activated so /projects/ works.
 *
 * @return void
 */
function flush_rewrites_on_activation() {
	register_project_post_type();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', __NAMESPACE__ . '\flush_rewrites_on_activation' );
