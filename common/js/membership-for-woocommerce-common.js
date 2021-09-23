(function( $ ) {
	'use strict';

	/**
	 * All of the code for your common JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );



jQuery(document).ready(function ($) {
$(".mwb_membership_buynow").on("click", function (e) {
	e.preventDefault();
	let plan_price = $('#mwb_membership_plan_price').val();
	let plan_id = $('#mwb_membership_plan_id').val();
	let plan_title = $('#mwb_membership_title').val();

	$.ajax({
		url: mfw_common_param.ajaxurl,
		type: "POST",
		data: {
			action: "mwb_membership_checkout",
			plan_price: plan_price,
			plan_id: plan_id,
			plan_title: plan_title,
		},

		success: function (response) {

			window.location.replace('cart');
		}
	});
});

});

