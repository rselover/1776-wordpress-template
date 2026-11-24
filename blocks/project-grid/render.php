<?php
/**
 * Server render for theme-1776/project-grid.
 *
 * @package Theme1776
 *
 * @var array<string, mixed> $attributes Block attributes (validated against block.json types).
 */

use function Theme1776\get_project_details;
use const Theme1776\PROJECT_POST_TYPE;
use const Theme1776\PROJECT_TAXONOMY;

defined( 'ABSPATH' ) || exit;

$theme_1776_count   = min( 12, max( 1, (int) $attributes['count'] ) );
$theme_1776_columns = min( 4, max( 1, (int) $attributes['columns'] ) );
$theme_1776_type    = sanitize_key( $attributes['projectType'] );

// On a single project, optionally leave the current project out ("More projects").
// One extra post is fetched and skipped in the loop, which avoids a slow post__not_in query.
$theme_1776_exclude = ! empty( $attributes['excludeCurrent'] ) && is_singular( PROJECT_POST_TYPE ) ? get_queried_object_id() : 0;

$theme_1776_args = array(
	'post_type'           => PROJECT_POST_TYPE,
	'posts_per_page'      => $theme_1776_exclude ? $theme_1776_count + 1 : $theme_1776_count,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true, // No pagination here, so skip the COUNT query.
);

if ( $theme_1776_type ) {
	// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Small, capped query on an indexed taxonomy.
	$theme_1776_args['tax_query'] = array(
		array(
			'taxonomy' => PROJECT_TAXONOMY,
			'field'    => 'slug',
			'terms'    => $theme_1776_type,
		),
	);
}

$theme_1776_projects = new WP_Query( $theme_1776_args );
$theme_1776_shown    = 0;

$theme_1776_wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'columns-' . $theme_1776_columns,
		'style' => '--t1776-columns:' . $theme_1776_columns . ';',
	)
);

if ( ! $theme_1776_projects->have_posts() ) {
	printf(
		'<div %1$s><p class="t1776-project-grid__empty">%2$s</p></div>',
		$theme_1776_wrapper, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes().
		esc_html__( 'No projects yet.', '1776-wordpress-template' )
	);
	return;
}
?>
<ul <?php echo $theme_1776_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>>
	<?php
	while ( $theme_1776_projects->have_posts() && $theme_1776_shown < $theme_1776_count ) :
		$theme_1776_projects->the_post();

		if ( get_the_ID() === $theme_1776_exclude ) {
			continue;
		}

		++$theme_1776_shown;
		$theme_1776_details = get_project_details( get_the_ID() );
		$theme_1776_terms   = get_the_terms( get_the_ID(), PROJECT_TAXONOMY );
		?>
		<li class="t1776-project-card">
			<a class="t1776-project-card__link" href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'medium_large', array( 'class' => 't1776-project-card__image' ) ); ?>
				<?php else : ?>
					<span class="t1776-project-card__placeholder" aria-hidden="true">
						<?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?>
					</span>
				<?php endif; ?>

				<span class="t1776-project-card__body">
					<?php if ( $theme_1776_terms && ! is_wp_error( $theme_1776_terms ) ) : ?>
						<span class="t1776-project-card__type"><?php echo esc_html( $theme_1776_terms[0]->name ); ?></span>
					<?php endif; ?>

					<span class="t1776-project-card__title"><?php the_title(); ?></span>

					<?php if ( $attributes['showExcerpt'] && has_excerpt() ) : ?>
						<span class="t1776-project-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></span>
					<?php endif; ?>

					<?php if ( $theme_1776_details['client'] || $theme_1776_details['year'] ) : ?>
						<span class="t1776-project-card__meta">
							<?php echo esc_html( implode( ' · ', array_filter( array( $theme_1776_details['client'], $theme_1776_details['year'] ) ) ) ); ?>
						</span>
					<?php endif; ?>
				</span>
			</a>
		</li>
	<?php endwhile; ?>
</ul>
<?php
wp_reset_postdata();
