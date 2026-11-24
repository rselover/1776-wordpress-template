<?php
/**
 * Title: Hero
 * Slug: theme-1776/hero
 * Categories: theme-1776, banner
 * Keywords: hero, intro, banner
 * Description: Large headline with an introduction and two buttons.
 *
 * @package Theme1776
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"parchment","layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull has-parchment-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
	<p class="is-style-eyebrow"><?php esc_html_e( 'Independent WordPress studio', '1776-wordpress-template' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"clamp(2.6rem, 6vw, 4.5rem)"}}} -->
	<h1 class="wp-block-heading" style="font-size:clamp(2.6rem, 6vw, 4.5rem)"><?php esc_html_e( 'Websites built by hand, made to last.', '1776-wordpress-template' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"large","textColor":"muted"} -->
	<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Custom WordPress themes and blocks written from a blank file: fast, accessible and easy for your team to edit.', '1776-wordpress-template' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'See the work', '1776-wordpress-template' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Start a project', '1776-wordpress-template' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
