( function( $ ) {
	/**
	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetElformHandler = function( $scope, $ ) {
		const form     = $scope.find( '.elform-form' )
		const post_id  = form.data( 'post_id' )
		const el_id    = form.data( 'el_id' )
		const msg_form = $scope.find( '.elform-form-msg' )

		form.on(
			'submit',
			function(e) {
				e.preventDefault()

				const formData = form.serialize();

				$.ajax(
					{
						method: 'POST',
						url: elementor_form_builder_obj.ajaxurl,
						data: {
							'action': 'elementor_form_builder_form_ajax',
							'data': formData,
							'post_id': post_id,
							'el_id': el_id,
							'nonce': elementor_form_builder_obj.nonce
						},
						success:function( res ) {
							msg_form.text( res.data.success_message )

							if ( res.data.redirect ) {
								window.location.href = res.data.redirect_to
							}

							console.log( res.data.success_message )
						},
						error: function( err ){
							msg_form.text( err.data.error_message )
							console.log( err )
						}
					}
				)
			}
		)
	}

	$( window ).on(
		'elementor/frontend/init',
		function() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/elform.default', WidgetElformHandler )
		}
	)
} )( jQuery )
