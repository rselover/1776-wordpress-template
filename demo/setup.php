<?php
/**
 * Demo content for the WordPress Playground live demo.
 *
 * Run by demo/blueprint.json after the theme is installed. NOT part of the
 * theme package (excluded via .gitattributes). It creates the pages, sample
 * projects, posts and menu a reviewer needs to see every template in use.
 *
 * Safe to run twice: it stops if the demo content already exists.
 *
 * @package Theme1776
 */

defined( 'ABSPATH' ) || exit;

if ( get_option( 't1776_demo_installed' ) ) {
	return;
}

/**
 * Insert a post and return its ID (0 on failure).
 *
 * @param array<string, mixed> $args wp_insert_post() arguments (unslashed).
 * @return int
 */
function t1776_demo_insert( array $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'post_status' => 'publish',
			'post_author' => 1,
		)
	);

	$id = wp_insert_post( wp_slash( $args ), true );

	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Create all demo content. Wrapped in a function so nothing touches globals
 * such as $post or $pages.
 *
 * @return void
 */
function t1776_demo_run() {
	// Remove WordPress's default sample content.
	foreach ( array(
		'hello-world' => 'post',
		'sample-page' => 'page',
	) as $slug => $type ) {
		$existing = get_page_by_path( $slug, OBJECT, $type );
		if ( $existing ) {
			wp_delete_post( $existing->ID, true );
		}
	}
	wp_delete_comment( 1, true );

	// ---------------------------------------------------------------------------
	// Pages.
	// ---------------------------------------------------------------------------
	$pages = array(
		'home'     => array(
			'post_title'   => 'Home',
			'post_content' => '<!-- wp:paragraph --><p>This page uses the theme\'s front-page template.</p><!-- /wp:paragraph -->',
		),
		'journal'  => array(
			'post_title'   => 'Journal',
			'post_content' => '',
		),
		'about'    => array(
			'post_title'   => 'About',
			'post_content' => '<!-- wp:pattern {"slug":"theme-1776/about-story"} /-->',
		),
		'services' => array(
			'post_title'   => 'Services',
			'post_content' => '<!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">Three ways we can help, from a brand-new build to keeping an existing site fast and secure.</p><!-- /wp:paragraph --><!-- wp:pattern {"slug":"theme-1776/services"} /--><!-- wp:pattern {"slug":"theme-1776/testimonials"} /--><!-- wp:pattern {"slug":"theme-1776/call-to-action"} /-->',
		),
		'contact'  => array(
			'post_title'   => 'Contact',
			'post_content' => '<!-- wp:pattern {"slug":"theme-1776/contact-section"} /-->',
		),
	);

	$page_ids = array();
	foreach ( $pages as $slug => $page ) {
		$page_ids[ $slug ] = t1776_demo_insert(
			$page + array(
				'post_type' => 'page',
				'post_name' => $slug,
			)
		);
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $page_ids['home'] );
	update_option( 'page_for_posts', $page_ids['journal'] );

	// ---------------------------------------------------------------------------
	// Projects.
	// ---------------------------------------------------------------------------
	$projects = array(
		array(
			'title'   => 'Harbor Light Trust',
			'type'    => 'Custom theme',
			'client'  => 'Harbor Light Trust',
			'year'    => '2026',
			'url'     => 'https://example.org/',
			'excerpt' => 'A from-scratch block theme for a regional charity, replacing a slow page-builder site.',
			'body'    => 'The old site took eight seconds to load on a phone and only one person knew how to edit it. We rebuilt it as a block theme with twelve patterns the communications team now uses every week.',
		),
		array(
			'title'   => 'Fieldstone Press',
			'type'    => 'Custom blocks',
			'client'  => 'Fieldstone Press',
			'year'    => '2026',
			'url'     => 'https://example.com/',
			'excerpt' => 'Book catalogue blocks backed by a custom post type, with author and series filters.',
			'body'    => 'Editors add a book once and it appears everywhere it should: series pages, author pages and seasonal lists, each rendered by a dynamic block.',
		),
		array(
			'title'   => 'Northgate Clinics',
			'type'    => 'Performance',
			'client'  => 'Northgate Clinics',
			'year'    => '2025',
			'url'     => '',
			'excerpt' => 'Core Web Vitals rescue: LCP from 4.8s to 1.6s without changing the design.',
			'body'    => 'An audit found render-blocking plugin assets and unoptimised hero images. We removed four plugins, wrote two small blocks to replace them, and added per-block CSS loading.',
		),
		array(
			'title'   => 'Old Mill Bakery',
			'type'    => 'Custom theme',
			'client'  => 'Old Mill Bakery',
			'year'    => '2025',
			'url'     => '',
			'excerpt' => 'A small, warm site with a weekly menu the owners update from their phone.',
			'body'    => 'The weekly menu is a custom block with day-by-day fields, so updating it takes two minutes and never breaks the layout.',
		),
		array(
			'title'   => 'Civic Data Lab',
			'type'    => 'Custom blocks',
			'client'  => 'Civic Data Lab',
			'year'    => '2024',
			'url'     => '',
			'excerpt' => 'Accessible chart and data-table blocks for a public research group.',
			'body'    => 'Every chart block ships with a data table fallback and passes WCAG 2.2 AA, so screen reader users get the same findings as everyone else.',
		),
	);

	foreach ( $projects as $index => $project ) {
		$id = t1776_demo_insert(
			array(
				'post_type'    => 't1776_project',
				'post_title'   => $project['title'],
				'post_excerpt' => $project['excerpt'],
				'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $project['body'] ) . '</p><!-- /wp:paragraph -->',
				'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( $index * 20 ) . ' days' ) ),
				'meta_input'   => array(
					't1776_client' => $project['client'],
					't1776_year'   => $project['year'],
					't1776_url'    => $project['url'],
				),
			)
		);

		if ( $id ) {
			wp_set_object_terms( $id, $project['type'], 't1776_project_type' );
		}
	}

	// ---------------------------------------------------------------------------
	// Blog posts.
	// ---------------------------------------------------------------------------
	$posts = array(
		array(
			'title'    => 'Why we build themes from a blank file',
			'category' => 'Process',
			'excerpt'  => 'Multipurpose themes ship thousands of lines you will never use. Here is what we do instead.',
			'body'     => array(
				'Most commercial themes try to be everything to everyone. That flexibility costs page weight, editor confusion and a long list of settings nobody remembers.',
				'Starting from a blank file means every template, pattern and block exists because the site needs it. The result is smaller, faster and much easier to hand over.',
			),
		),
		array(
			'title'    => 'Dynamic blocks and why they age well',
			'category' => 'Development',
			'excerpt'  => 'Rendering blocks on the server keeps saved content clean and lets markup change safely later.',
			'body'     => array(
				'A static block saves its HTML into the post. Change the markup later and every old post shows a validation warning.',
				'A dynamic block saves only its settings and renders on the server with render.php. Update the template once and every page that uses it updates too.',
			),
		),
		array(
			'title'    => 'A contact form without a plugin',
			'category' => 'Development',
			'excerpt'  => 'Nonces, a honeypot, rate limiting and a saved copy of every message, in about 250 lines of PHP.',
			'body'     => array(
				'Form plugins are convenient, but they bring a lot of code for one form. This theme posts to admin-post.php and handles the request itself.',
				'Every message is stored as a private post before the email is sent, so a broken mail server never loses a lead.',
			),
		),
		array(
			'title'    => 'Accessibility is a build step, not a checklist',
			'category' => 'Accessibility',
			'excerpt'  => 'Focus styles, real labels and reduced motion belong in the first commit, not the last.',
			'body'     => array(
				'We add visible focus styles, labelled form fields and a reduced-motion media query before writing any page-specific CSS.',
				'Catching issues while building is far cheaper than an audit after launch.',
			),
		),
	);

	foreach ( $posts as $index => $post ) {
		$category = term_exists( $post['category'], 'category' );
		if ( ! $category ) {
			$category = wp_insert_term( $post['category'], 'category' );
		}

		$content = '';
		foreach ( $post['body'] as $paragraph ) {
			$content .= '<!-- wp:paragraph --><p>' . esc_html( $paragraph ) . '</p><!-- /wp:paragraph -->';
		}

		t1776_demo_insert(
			array(
				'post_type'     => 'post',
				'post_title'    => $post['title'],
				'post_excerpt'  => $post['excerpt'],
				'post_content'  => $content,
				'post_date'     => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( 3 + $index * 9 ) . ' days' ) ),
				'post_category' => is_wp_error( $category ) ? array() : array( (int) $category['term_id'] ),
			)
		);
	}

	// ---------------------------------------------------------------------------
	// Navigation menu (used by the header and footer Navigation blocks).
	// ---------------------------------------------------------------------------
	$nav_items = array(
		array( 'Work', home_url( '/projects/' ), 0 ),
		array( 'Services', get_permalink( $page_ids['services'] ), $page_ids['services'] ),
		array( 'About', get_permalink( $page_ids['about'] ), $page_ids['about'] ),
		array( 'Journal', get_permalink( $page_ids['journal'] ), $page_ids['journal'] ),
		array( 'Contact', get_permalink( $page_ids['contact'] ), $page_ids['contact'] ),
	);

	$nav_markup = '';
	foreach ( $nav_items as $item ) {
		list( $label, $url, $page_id ) = $item;

		$attrs = $page_id
			? array(
				'label' => $label,
				'type'  => 'page',
				'id'    => $page_id,
				'url'   => $url,
				'kind'  => 'post-type',
			)
			: array(
				'label' => $label,
				'url'   => $url,
				'kind'  => 'custom',
			);

		$nav_markup .= '<!-- wp:navigation-link ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES ) . ' /-->';
	}

	t1776_demo_insert(
		array(
			'post_type'    => 'wp_navigation',
			'post_title'   => 'Main menu',
			'post_content' => $nav_markup,
		)
	);

	// ---------------------------------------------------------------------------
	// Site options.
	// ---------------------------------------------------------------------------
	update_option( 'blogname', '1776' );
	update_option( 'blogdescription', 'Websites built by hand, made to last.' );

	// Update the live rewrite object too; updating the option alone would
	// flush rules built from the old (plain) structure.
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	flush_rewrite_rules();

	update_option( 't1776_demo_installed', time() );
}

t1776_demo_run();
