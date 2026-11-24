/**
 * Editor UI for theme-1776/contact-form.
 *
 * The form itself is rendered by render.php; the editor shows that preview
 * and lets the editor change the button label.
 */
( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, TextControl, Disabled } = wp.components;
	const ServerSideRender = wp.serverSideRender;

	function Edit( { attributes, setAttributes } ) {
		return el(
			Fragment,
			null,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __( 'Settings', '1776-wordpress-template' ) },
					el( TextControl, {
						label: __( 'Button label', '1776-wordpress-template' ),
						value: attributes.submitLabel,
						placeholder: __( 'Send message', '1776-wordpress-template' ),
						onChange: ( submitLabel ) => setAttributes( { submitLabel } ),
						help: __( 'Messages appear under Messages in the admin and are emailed to the site admin.', '1776-wordpress-template' ),
						__nextHasNoMarginBottom: true,
					} )
				)
			),
			el(
				'div',
				useBlockProps(),
				el( Disabled, null, el( ServerSideRender, { block: 'theme-1776/contact-form', attributes } ) )
			)
		);
	}

	registerBlockType( 'theme-1776/contact-form', {
		edit: Edit,
		save: () => null,
	} );
} )( window.wp );
