<?php
/**
 * Title: Call to action
 * Slug: theme-1776/call-to-action
 * Categories: theme-1776, call-to-action
 * Keywords: cta, contact, banner
 * Description: Dark banner inviting visitors to get in touch.
 *
 * @package Theme1776
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}},"elements":{"heading":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Have a site that needs building, or rebuilding?', '1776-wordpress-template' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center"><?php esc_html_e( 'Tell us what you are working on. You will hear back from a developer, not a sales team.', '1776-wordpress-template' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"brick","textColor":"base"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-brick-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get in touch', '1776-wordpress-template' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
