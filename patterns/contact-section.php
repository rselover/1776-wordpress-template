<?php
/**
 * Title: Contact section
 * Slug: theme-1776/contact-section
 * Categories: theme-1776-pages, contact
 * Keywords: contact, form, email
 * Description: Contact details beside the Contact Form block.
 *
 * @package Theme1776
 */

?>
<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide">
	<!-- wp:column {"width":"38%"} -->
	<div class="wp-block-column" style="flex-basis:38%">
		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Tell us a little about your project and timeline. We reply within one business day.', '1776-wordpress-template' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:list {"className":"is-style-stars"} -->
		<ul class="wp-block-list is-style-stars">
			<!-- wp:list-item -->
			<li><?php esc_html_e( 'New sites and redesigns', '1776-wordpress-template' ); ?></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><?php esc_html_e( 'Custom blocks for an existing site', '1776-wordpress-template' ); ?></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><?php esc_html_e( 'Performance and accessibility audits', '1776-wordpress-template' ); ?></li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:theme-1776/contact-form /-->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
