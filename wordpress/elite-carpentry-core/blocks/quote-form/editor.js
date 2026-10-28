/**
 * Quote Request Form – editor UI. Plain JS (no build step): the form itself is
 * rendered by PHP and previewed here with ServerSideRender.
 */
( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var be = wp.blockEditor;
	var c = wp.components;
	var ServerSideRender = wp.serverSideRender;

	wp.blocks.registerBlockType( 'elite-carpentry/quote-form', {
		edit: function ( props ) {
			var a = props.attributes;
			var set = props.setAttributes;
			return el(
				'div',
				be.useBlockProps(),
				el(
					be.InspectorControls,
					null,
					el(
						c.PanelBody,
						{ title: __( 'Form settings', 'elite-carpentry-core' ) },
						el( c.ToggleControl, {
							label: __( 'Compact (name, email, phone, message only)', 'elite-carpentry-core' ),
							checked: !! a.compact,
							onChange: function ( v ) { set( { compact: v } ); },
						} ),
						el( c.TextControl, {
							label: __( 'Button text', 'elite-carpentry-core' ),
							value: a.buttonText,
							onChange: function ( v ) { set( { buttonText: v } ); },
						} ),
						el( c.TextareaControl, {
							label: __( 'Success message', 'elite-carpentry-core' ),
							value: a.successMessage,
							onChange: function ( v ) { set( { successMessage: v } ); },
						} ),
						el( 'p', { className: 'components-base-control__help' },
							__( 'Submissions are saved under Quote Requests and emailed to the address in Settings → Business Details.', 'elite-carpentry-core' )
						)
					)
				),
				el( 'div', { style: { pointerEvents: 'none' } },
					el( ServerSideRender, { block: 'elite-carpentry/quote-form', attributes: a } )
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
