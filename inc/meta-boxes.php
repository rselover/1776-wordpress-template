<?php
/**
 * "Project details" meta box for the Project post type.
 *
 * A classic meta box keeps this build-step free and works in the block
 * editor's sidebar. The meta is also exposed in REST (see post-types.php),
 * so a future React sidebar panel could replace this without data changes.
 *
 * @package Theme1776
 */

namespace Theme1776\MetaBoxes;

use function Theme1776\get_project_details;
use function Theme1776\project_meta_fields;
use const Theme1776\PROJECT_POST_TYPE;

defined( 'ABSPATH' ) || exit;

const NONCE_ACTION = 't1776_save_project_details';
const NONCE_FIELD  = 't1776_project_details_nonce';

/**
 * Register the meta box.
 *
 * @return void
 */
function add_project_meta_box() {
	add_meta_box(
		't1776-project-details',
		__( 'Project details', '1776-wordpress-template' ),
		__NAMESPACE__ . '\render_project_meta_box',
		PROJECT_POST_TYPE,
		'side'
	);
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\add_project_meta_box' );

/**
 * Output the meta box fields.
 *
 * @param \WP_Post $post Current post.
 * @return void
 */
function render_project_meta_box( $post ) {
	$details = get_project_details( $post->ID );
	$labels  = project_meta_fields();

	wp_nonce_field( NONCE_ACTION, NONCE_FIELD );
	?>
	<p>
		<label for="t1776_client"><?php echo esc_html( $labels['t1776_client'] ); ?></label><br>
		<input type="text" id="t1776_client" name="t1776_client" class="widefat" value="<?php echo esc_attr( $details['client'] ); ?>">
	</p>
	<p>
		<label for="t1776_year"><?php echo esc_html( $labels['t1776_year'] ); ?></label><br>
		<input type="number" id="t1776_year" name="t1776_year" class="widefat" min="1776" max="2100" step="1" value="<?php echo esc_attr( $details['year'] ); ?>">
	</p>
	<p>
		<label for="t1776_url"><?php echo esc_html( $labels['t1776_url'] ); ?></label><br>
		<input type="url" id="t1776_url" name="t1776_url" class="widefat" placeholder="https://" value="<?php echo esc_attr( $details['url'] ); ?>">
	</p>
	<?php
}

/**
 * Save the meta box values.
 *
 * Checks, in order: nonce, autosave, capability. Each value is unslashed and
 * sanitized as text here, then the field-specific sanitize_callback
 * registered with register_post_meta() runs inside update_post_meta().
 *
 * @param int $post_id Post ID.
 * @return void
 */
function save_project_meta_box( $post_id ) {
	if ( ! isset( $_POST[ NONCE_FIELD ] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST[ NONCE_FIELD ] ) );

	if ( ! wp_verify_nonce( $nonce, NONCE_ACTION ) ) {
		return;
	}

	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( project_meta_fields() ) as $key ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$value = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );

		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_' . PROJECT_POST_TYPE, __NAMESPACE__ . '\save_project_meta_box' );
