<?php
/**
 * Title: Footer content
 * Slug: theme-1776/footer-content
 * Inserter: no
 * Description: Site footer with tagline, links and a copyright line that updates its year.
 *
 * @package Theme1776
 */

?>
<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
	<div class="wp-block-group">
		<!-- wp:site-title {"level":0} /-->
		<!-- wp:site-tagline {"textColor":"muted","fontSize":"small"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} /-->
</div>
<!-- /wp:group -->

<!-- wp:separator {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|30"}}}} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--30)"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"align":"wide","textColor":"muted","fontSize":"x-small"} -->
<p class="alignwide has-muted-color has-text-color has-x-small-font-size">
	<?php
	printf(
		/* translators: 1: current year, 2: site name. */
		esc_html__( '© %1$s %2$s. Hand-built with WordPress.', '1776-wordpress-template' ),
		esc_html( wp_date( 'Y' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
	?>
</p>
<!-- /wp:paragraph -->
