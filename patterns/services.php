<?php
/**
 * Title: Services
 * Slug: theme-1776/services
 * Categories: theme-1776, services
 * Keywords: services, features, offer
 * Description: Three service cards with a section heading.
 *
 * @package Theme1776
 */

$theme_1776_services = array(
	array(
		'title' => __( 'Custom themes', '1776-wordpress-template' ),
		'text'  => __( 'Block themes written from scratch around your brand, with templates and patterns your editors can actually use.', '1776-wordpress-template' ),
		'items' => array(
			__( 'Design tokens in theme.json', '1776-wordpress-template' ),
			__( 'Editable templates and patterns', '1776-wordpress-template' ),
		),
	),
	array(
		'title' => __( 'Custom blocks', '1776-wordpress-template' ),
		'text'  => __( 'Purpose-built blocks for the content you publish most, rendered on the server and safe by default.', '1776-wordpress-template' ),
		'items' => array(
			__( 'Dynamic, cache-friendly output', '1776-wordpress-template' ),
			__( 'Custom post types and fields', '1776-wordpress-template' ),
		),
	),
	array(
		'title' => __( 'Care and performance', '1776-wordpress-template' ),
		'text'  => __( 'Audits, Core Web Vitals work and ongoing maintenance for sites that need to stay quick and secure.', '1776-wordpress-template' ),
		'items' => array(
			__( 'Accessibility reviews', '1776-wordpress-template' ),
			__( 'Updates and monitoring', '1776-wordpress-template' ),
		),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
	<p class="is-style-eyebrow"><?php esc_html_e( 'Services', '1776-wordpress-template' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading -->
	<h2 class="wp-block-heading"><?php esc_html_e( 'What we build', '1776-wordpress-template' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $theme_1776_services as $theme_1776_service ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group is-style-card" style="min-height:100%;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading"><?php echo esc_html( $theme_1776_service['title'] ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p><?php echo esc_html( $theme_1776_service['text'] ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:list {"className":"is-style-stars","fontSize":"small"} -->
				<ul class="wp-block-list is-style-stars has-small-font-size">
					<?php foreach ( $theme_1776_service['items'] as $theme_1776_item ) : ?>
					<!-- wp:list-item -->
					<li><?php echo esc_html( $theme_1776_item ); ?></li>
					<!-- /wp:list-item -->
					<?php endforeach; ?>
				</ul>
				<!-- /wp:list -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
