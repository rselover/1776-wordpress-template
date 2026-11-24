<?php
/**
 * Title: Latest posts
 * Slug: theme-1776/latest-posts
 * Categories: theme-1776, query
 * Keywords: blog, news, posts
 * Block Types: core/query
 * Description: The three most recent posts in a grid.
 *
 * @package Theme1776
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"parchment","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group alignfull has-parchment-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
	<p class="is-style-eyebrow"><?php esc_html_e( 'Journal', '1776-wordpress-template' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading -->
	<h2 class="wp-block-heading"><?php esc_html_e( 'Notes from the workshop', '1776-wordpress-template' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"align":"wide"} -->
	<div class="wp-block-query alignwide">
		<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group is-style-card" style="min-height:100%;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:post-date /-->
				<!-- wp:post-title {"isLink":true,"level":3} /-->
				<!-- wp:post-excerpt {"fontSize":"small"} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
