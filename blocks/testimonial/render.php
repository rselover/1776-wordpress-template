<?php
/**
 * Server render for theme-1776/testimonial.
 *
 * Attributes are stored as plain text and escaped here on output, so no
 * markup typed by an editor ever reaches the page unescaped.
 *
 * @package Theme1776
 *
 * @var array<string, mixed> $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$theme_1776_quote = trim( (string) $attributes['quote'] );

if ( '' === $theme_1776_quote ) {
	return;
}

$theme_1776_name = trim( (string) $attributes['name'] );
$theme_1776_role = trim( (string) $attributes['role'] );
?>
<figure <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>>
	<blockquote class="t1776-testimonial__quote">
		<p><?php echo nl2br( esc_html( $theme_1776_quote ) ); ?></p>
	</blockquote>
	<?php if ( $theme_1776_name ) : ?>
		<figcaption class="t1776-testimonial__caption">
			<span class="t1776-testimonial__name"><?php echo esc_html( $theme_1776_name ); ?></span>
			<?php if ( $theme_1776_role ) : ?>
				<span class="t1776-testimonial__role"><?php echo esc_html( $theme_1776_role ); ?></span>
			<?php endif; ?>
		</figcaption>
	<?php endif; ?>
</figure>
