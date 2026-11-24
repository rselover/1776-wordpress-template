<?php
/**
 * Script dependencies for this block's editor script.
 *
 * Hand-written equivalent of the file @wordpress/scripts generates, so the
 * blocks work without a build step. The version busts caches on change.
 *
 * @package Theme1776
 */

return array(
	'dependencies' => array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n', 'wp-server-side-render', 'wp-data' ),
	'version'      => (string) filemtime( __DIR__ . '/index.js' ),
);
