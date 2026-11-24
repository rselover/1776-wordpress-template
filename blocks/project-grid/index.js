/**
 * Editor UI for theme-1776/project-grid.
 *
 * Written as plain browser JavaScript (no JSX, no build step) so the theme
 * installs straight from Git. Block name, attributes and supports come from
 * block.json via the server registration; this file only adds the editor UI.
 * The preview is rendered by render.php through ServerSideRender, so the
 * editor and the front end always match.
 */
( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, SelectControl, ToggleControl, Disabled } = wp.components;
	const { useSelect } = wp.data;
	const ServerSideRender = wp.serverSideRender;

	function Edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps();

		const types = useSelect(
			( select ) =>
				select( 'core' ).getEntityRecords( 'taxonomy', 't1776_project_type', {
					per_page: 100,
					_fields: 'id,name,slug',
				} ),
			[]
		);

		const typeOptions = [ { label: __( 'All types', '1776-wordpress-template' ), value: '' } ].concat(
			( types || [] ).map( ( term ) => ( { label: term.name, value: term.slug } ) )
		);

		return el(
			Fragment,
			null,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __( 'Settings', '1776-wordpress-template' ) },
					el( RangeControl, {
						label: __( 'Number of projects', '1776-wordpress-template' ),
						value: attributes.count,
						min: 1,
						max: 12,
						onChange: ( count ) => setAttributes( { count } ),
						__nextHasNoMarginBottom: true,
					} ),
					el( RangeControl, {
						label: __( 'Columns', '1776-wordpress-template' ),
						value: attributes.columns,
						min: 1,
						max: 4,
						onChange: ( columns ) => setAttributes( { columns } ),
						__nextHasNoMarginBottom: true,
					} ),
					el( SelectControl, {
						label: __( 'Project type', '1776-wordpress-template' ),
						value: attributes.projectType,
						options: typeOptions,
						onChange: ( projectType ) => setAttributes( { projectType } ),
						__nextHasNoMarginBottom: true,
					} ),
					el( ToggleControl, {
						label: __( 'Show summary', '1776-wordpress-template' ),
						checked: attributes.showExcerpt,
						onChange: ( showExcerpt ) => setAttributes( { showExcerpt } ),
						__nextHasNoMarginBottom: true,
					} ),
					el( ToggleControl, {
						label: __( 'Hide the current project', '1776-wordpress-template' ),
						help: __( 'For "More projects" sections on a single project page.', '1776-wordpress-template' ),
						checked: attributes.excludeCurrent,
						onChange: ( excludeCurrent ) => setAttributes( { excludeCurrent } ),
						__nextHasNoMarginBottom: true,
					} )
				)
			),
			el(
				'div',
				blockProps,
				el( Disabled, null, el( ServerSideRender, { block: 'theme-1776/project-grid', attributes } ) )
			)
		);
	}

	registerBlockType( 'theme-1776/project-grid', {
		edit: Edit,
		save: () => null,
	} );
} )( window.wp );
