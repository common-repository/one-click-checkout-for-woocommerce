(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

	$(document).ready(function(){

		//JS for applying Buy Now Button Background Color.
		if($('.mwb_woo_text_and_background_color').attr('data-buttonbackgroundcolor') != null){

			var background_color = $('.mwb_woo_text_and_background_color').attr('data-buttonbackgroundcolor');

			$('.mwb_woo_one_click_checkout_user_buynow_shop').each(function(){
				$(this).css('background-color',background_color,'important');
			});

			$('.mwb_woo_one_click_checkout_user_buynow_single').css('background-color',background_color,'important');
			$('.mwb_woo_one_click_checkout_user_buynow_single_variable').css('background-color',background_color,'important');
		}

		//JS for applying Buy now button text color.
		if($('.mwb_woo_text_and_background_color').attr('data-textcolor') != null){

			var background_textcolor = $('.mwb_woo_text_and_background_color').attr('data-textcolor');

			$('.mwb_woo_one_click_checkout_user_buynow_shop').each(function(){
				$(this).css('color',background_textcolor,'important');
			});

			$('.mwb_woo_one_click_checkout_user_buynow_single').css('color',background_textcolor,'important');
			$('.mwb_woo_one_click_checkout_user_buynow_single_variable').css('color',background_textcolor,'important');

		}

		// JS for Shop page simple, external and grouped product add to cart.
		$('.mwb_woo_one_click_checkout_user_buynow_shop').on('click', function(){

			var mwb_wocc_product_type = $(this).attr('data-productType');
	 		var mwb_wocc_product_id   = $(this).attr('data-productId');

			 $.ajax({
				url   : mwocc_common_param.ajaxurl,
				type  : 'POST',
				cache : false,
				data : {
					action : 'mwocc_product_added_cart_redirect_checkout',
					mwb_woo_chckout_product_id : mwb_wocc_product_id,
					nonce : mwocc_common_param.nonce,
				},
				success : function(response){
					if(response == 'success'){
						window.location.href = mwocc_common_param.checkoutpage_url;
					}
				}
			});
		});

		// JS for single page simple, external and grouped product add to cart.
		$('.mwb_woo_one_click_checkout_user_buynow_single').on('click', function(){

			var mwb_wocc_product_type = $(this).attr('data-productType');
	 		var mwb_wocc_product_id   = $(this).attr('data-productId');

			 $.ajax({
				url   : mwocc_common_param.ajaxurl,
				type  : 'POST',
				cache : false,
				data : {
					action : 'mwocc_product_added_cart_redirect_checkout',
					mwb_woo_chckout_product_id : mwb_wocc_product_id,
					nonce : mwocc_common_param.nonce,
				},
				success : function(response){
					if(response == 'success'){
						window.location.href = mwocc_common_param.checkoutpage_url;
					}
				}
			});

		});

		// JS for single page variable product add to cart.
		$('.mwb_woo_one_click_checkout_user_buynow_single_variable').on('click', function(){

			var mwb_wocc_selected_variation_id = $(document).find('.variation_id').val();
	 		var mwb_wocc_product_id = $(this).attr('data-productId');

			 if(mwb_wocc_selected_variation_id != 0 ){
				$.ajax({
					url : mwocc_common_param.ajaxurl,
					type : 'POST',
					cache : false,
					data : {
						action : 'mwocc_product_added_cart_redirect_checkout',
						mwb_woo_chckout_product_id : mwb_wocc_product_id,
						mwb_woo_variation_id       : mwb_wocc_selected_variation_id,
						nonce : mwocc_common_param.nonce,
					},success : function(response){
						if(response == 'success'){
							window.location.href = mwocc_common_param.checkoutpage_url;
						}
					}
				});

			 }else{
	 			$(document).find('#mwb_wocc_variable_product_error_message').addClass('woocommerce-message');
	 			$(document).find('#mwb_wocc_variable_product_error_message').attr('role','alert');
	 			$(document).find('#mwb_wocc_variable_product_error_message').html(mwocc_common_param.mwb_woo_one_click_checkout_msg);
	 			$(document).find('#mwb_wocc_variable_product_error_message').fadeOut(8000);
	 		}

		});

	});

})( jQuery );
