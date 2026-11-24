<?php
/**
 * Title: About: story and values
 * Slug: theme-1776/about-story
 * Categories: theme-1776-pages
 * Keywords: about, team, values
 * Description: Intro paragraph and three values for an About page.
 *
 * @package Theme1776
 */

?>
<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( '1776 is a small, independent studio that builds WordPress sites the long way: from a blank file, one decision at a time.', '1776-wordpress-template' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'We skip the bloated multipurpose themes and page builders. Instead, every template, pattern and block is written for the site it serves, so pages load quickly, editors get exactly the tools they need, and the next developer can read the code.', '1776-wordpress-template' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-stars"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-stars"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'How we work', '1776-wordpress-template' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"is-style-stars"} -->
<ul class="wp-block-list is-style-stars">
	<!-- wp:list-item -->
	<li><strong><?php esc_html_e( 'Standards first.', '1776-wordpress-template' ); ?></strong> <?php esc_html_e( 'WordPress coding standards, escaped output and accessible markup on every project.', '1776-wordpress-template' ); ?></li>
	<!-- /wp:list-item -->

	<!-- wp:list-item -->
	<li><strong><?php esc_html_e( 'Editors are users too.', '1776-wordpress-template' ); ?></strong> <?php esc_html_e( 'Patterns and blocks are designed so your team can publish without breaking the layout.', '1776-wordpress-template' ); ?></li>
	<!-- /wp:list-item -->

	<!-- wp:list-item -->
	<li><strong><?php esc_html_e( 'Nothing you do not need.', '1776-wordpress-template' ); ?></strong> <?php esc_html_e( 'No page builders, no plugin pile-ups, no mystery code.', '1776-wordpress-template' ); ?></li>
	<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
