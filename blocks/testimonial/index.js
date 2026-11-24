/**
 * Editor UI for theme-1776/testimonial.
 *
 * Fields are edited inline with PlainText, so the editor looks like the
 * front end and only plain text is stored (render.php escapes it).
 */
( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { __ } = wp.i18n;
	const { useBlockProps, PlainText } = wp.blockEditor;

	function Edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps();

		return el(
			'figure',
			blockProps,
			el(
				'blockquote',
				{ className: 't1776-testimonial__quote' },
				el( PlainText, {
					value: attributes.quote,
					onChange: ( quote ) => setAttributes( { quote } ),
					placeholder: __( 'What did the client say?', '1776-wordpress-template' ),
					'aria-label': __( 'Quote', '1776-wordpress-template' ),
				} )
			),
			el(
				'figcaption',
				{ className: 't1776-testimonial__caption' },
				el( PlainText, {
					className: 't1776-testimonial__name',
					value: attributes.name,
					onChange: ( name ) => setAttributes( { name } ),
					placeholder: __( 'Name', '1776-wordpress-template' ),
					'aria-label': __( 'Name', '1776-wordpress-template' ),
				} ),
				el( PlainText, {
					className: 't1776-testimonial__role',
					value: attributes.role,
					onChange: ( role ) => setAttributes( { role } ),
					placeholder: __( 'Role, company', '1776-wordpress-template' ),
					'aria-label': __( 'Role', '1776-wordpress-template' ),
				} )
			)
		);
	}

	registerBlockType( 'theme-1776/testimonial', {
		edit: Edit,
		save: () => null,
	} );
} )( window.wp );
