<?php
/**
 * Title: Featured projects
 * Slug: theme-1776/featured-projects
 * Categories: theme-1776, portfolio
 * Keywords: portfolio, projects, work
 * Description: Section heading with the Project Grid block and a link to all projects.
 *
 * @package Theme1776
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"parchment","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-parchment-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
			<p class="is-style-eyebrow"><?php esc_html_e( 'Selected work', '1776-wordpress-template' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading -->
			<h2 class="wp-block-heading"><?php esc_html_e( 'Recent projects', '1776-wordpress-template' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:paragraph -->
		<p><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'All projects', '1776-wordpress-template' ); ?> &rarr;</a></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:theme-1776/project-grid {"count":3,"columns":3,"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} /-->
</div>
<!-- /wp:group -->
