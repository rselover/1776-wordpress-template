<?php
/**
 * Title: Testimonials
 * Slug: theme-1776/testimonials
 * Categories: theme-1776, testimonials
 * Keywords: quotes, reviews, clients
 * Description: Two client testimonials side by side.
 *
 * @package Theme1776
 */

$theme_1776_quotes = array(
	array(
		'quote' => __( 'The new site loads in under a second and our team updates it without calling anyone. That was the whole brief.', '1776-wordpress-template' ),
		'name'  => __( 'Jordan Ellis', '1776-wordpress-template' ),
		'role'  => __( 'Director, Harbor Light Trust', '1776-wordpress-template' ),
	),
	array(
		'quote' => __( 'Clean code, clear handover notes, and blocks our editors actually enjoy using.', '1776-wordpress-template' ),
		'name'  => __( 'Priya Nair', '1776-wordpress-template' ),
		'role'  => __( 'Head of Digital, Fieldstone Press', '1776-wordpress-template' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:separator {"className":"is-style-stars"} -->
	<hr class="wp-block-separator has-alpha-channel-opacity is-style-stars"/>
	<!-- /wp:separator -->

	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Kind words', '1776-wordpress-template' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $theme_1776_quotes as $theme_1776_quote ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:theme-1776/testimonial <?php echo wp_json_encode( $theme_1776_quote, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ); ?> /-->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
