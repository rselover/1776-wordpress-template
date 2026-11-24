<?php
/**
 * Server render for theme-1776/project-details.
 *
 * Reads the current project from block context, so it works inside the
 * single project template and inside a Query Loop.
 *
 * @package Theme1776
 *
 * @var WP_Block $block Block instance (provides postId / postType context).
 */

use function Theme1776\get_project_details;
use function Theme1776\project_meta_fields;
use const Theme1776\PROJECT_POST_TYPE;
use const Theme1776\PROJECT_TAXONOMY;

defined( 'ABSPATH' ) || exit;

$theme_1776_post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : 0;

if ( ! $theme_1776_post_id || PROJECT_POST_TYPE !== get_post_type( $theme_1776_post_id ) ) {
	return;
}

$theme_1776_details = get_project_details( $theme_1776_post_id );
$theme_1776_labels  = project_meta_fields();
$theme_1776_types   = get_the_term_list( $theme_1776_post_id, PROJECT_TAXONOMY, '', ', ' );
$theme_1776_rows    = array();

if ( $theme_1776_details['client'] ) {
	$theme_1776_rows[ $theme_1776_labels['t1776_client'] ] = esc_html( $theme_1776_details['client'] );
}

if ( $theme_1776_details['year'] ) {
	$theme_1776_rows[ $theme_1776_labels['t1776_year'] ] = esc_html( $theme_1776_details['year'] );
}

if ( $theme_1776_types && ! is_wp_error( $theme_1776_types ) ) {
	$theme_1776_rows[ __( 'Type', '1776-wordpress-template' ) ] = wp_kses(
		$theme_1776_types,
		array(
			'a' => array(
				'href' => array(),
				'rel'  => array(),
			),
		)
	);
}

if ( $theme_1776_details['url'] ) {
	$theme_1776_rows[ $theme_1776_labels['t1776_url'] ] = sprintf(
		'<a href="%1$s" rel="noopener">%2$s</a>',
		esc_url( $theme_1776_details['url'] ),
		esc_html( wp_parse_url( $theme_1776_details['url'], PHP_URL_HOST ) )
	);
}

if ( ! $theme_1776_rows ) {
	return;
}
?>
<dl <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>>
	<?php foreach ( $theme_1776_rows as $theme_1776_label => $theme_1776_value ) : ?>
		<div class="t1776-project-details__row">
			<dt><?php echo esc_html( $theme_1776_label ); ?></dt>
			<dd><?php echo $theme_1776_value; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Each value is escaped when built above. ?></dd>
		</div>
	<?php endforeach; ?>
</dl>
