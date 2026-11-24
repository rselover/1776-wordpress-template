/**
 * Editor UI for theme-1776/project-details.
 *
 * Shows the server-rendered details for the post being edited. In the Site
 * Editor (no real post yet) it shows a short placeholder instead.
 */
( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { __ } = wp.i18n;
	const { useBlockProps } = wp.blockEditor;
	const { Disabled, Placeholder } = wp.components;
	const ServerSideRender = wp.serverSideRender;

	function Edit( { context } ) {
		const blockProps = useBlockProps();

		if ( ! context.postId || context.postType !== 't1776_project' ) {
			return el(
				'div',
				blockProps,
				el( Placeholder, {
					icon: 'info-outline',
					label: __( 'Project Details', '1776-wordpress-template' ),
					instructions: __( 'Shows client, year, type and live link for the current project.', '1776-wordpress-template' ),
				} )
			);
		}

		return el(
			'div',
			blockProps,
			el(
				Disabled,
				null,
				el( ServerSideRender, {
					block: 'theme-1776/project-details',
					urlQueryArgs: { post_id: context.postId },
					EmptyResponsePlaceholder: () =>
						el( 'p', null, __( 'Add client, year or a link in the Project details panel.', '1776-wordpress-template' ) ),
				} )
			)
		);
	}

	registerBlockType( 'theme-1776/project-details', {
		edit: Edit,
		save: () => null,
	} );
} )( window.wp );
