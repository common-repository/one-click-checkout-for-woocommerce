(function ($) {
  "use strict";

  /**
   * All of the code for your admin-facing JavaScript source
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

  $(document).ready(function () {

    const MDCText = mdc.textField.MDCTextField;
    const textField = [].map.call(
      document.querySelectorAll(".mdc-text-field"),
      function (el) {
        return new MDCText(el);
      }
    );

    const MDCRipple = mdc.ripple.MDCRipple;
    const buttonRipple = [].map.call(
      document.querySelectorAll(".mdc-button"),
      function (el) {
        return new MDCRipple(el);
      }
    );

    const MDCSwitch = mdc.switchControl.MDCSwitch;
    const switchControl = [].map.call(
      document.querySelectorAll(".mdc-switch"),
      function (el) {
        return new MDCSwitch(el);
      }
    );

    $(".mwb-password-hidden").on('click', function () {
      if ($(".mwb-form__password").attr("type") == "text") {
        $(".mwb-form__password").attr("type", "password");
      } else {
        $(".mwb-form__password").attr("type", "text");
      }
    });

    // JS Implementation start here.
    var mwb_wocc_all_included_products = [];
	 	var mwb_wocc_all_included_products_text = [];

    // Adding button color and button text color
    $('#mwb_occfw_checkout_button_back_color').wpColorPicker();
    $('#mwb_occfw_checkout_button_text_color').wpColorPicker();

    // make mulitple hidden fields.
    $('#mwb_woo_one_click_checkout_include_hidden_products').select2();

    // Make include option multiple.
    $('#mwb_woo_one_click_checkout_include_products').select2();

    // Make exclude option multiple.
    $('#mwb_woo_one_click_checkout_exclude_products').select2();

    // Make Category option multiple.
    $('#mwb_woo_one_click_checkout_product_categories').select2();

    // Validation for time frame text field.
    $("#mwb_woo_one_click_checkout_cookie_time").keypress(function (e) {
      if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '.' && (e.which < 48 || e.which > 57)) {
        return false;
      }
    });

    // Hide multi-select option of include and exclude dropdown.
    $('#mwb_woo_one_click_checkout_include_hidden_products').closest('tr').hide();

    // Store all included product options value in array.
    $('#mwb_woo_one_click_checkout_include_hidden_products option').each(function(e){
			
			mwb_wocc_all_included_products.push($(this).attr('value'));
			mwb_wocc_all_included_products_text[$(this).attr('value')] = $(this).text();
		});

    // JS for include and exclude selected product.
    var selected_included_products = $( '#mwb_woo_one_click_checkout_include_products' ).val();
		var selected_excluded_products = $( '#mwb_woo_one_click_checkout_exclude_products' ).val();

		$.each( selected_included_products , function( key , value ){
			$("#mwb_woo_one_click_checkout_exclude_products option[value="+value+"]").remove();
		} );

		$.each( selected_excluded_products , function( key , value ){
			$("#mwb_woo_one_click_checkout_include_products option[value="+value+"]").remove();
		} );

    // JS for on change value in included product multiselect.
    $( document ).on( 'change', '#mwb_woo_one_click_checkout_include_products', function(){

      var mwb_woocc_hidden_product_value              = []; 
			var mwb_woocc_previously_selected_product_value = []; 

			var mwb_woocc_selected_include_products         = $('#mwb_woo_one_click_checkout_include_products' ).val();
			var mwb_woocc_selected_excluded_products        = $('#mwb_woo_one_click_checkout_exclude_products' ).val();
      var mwb_woocc_previously_selected_product_value = $( '#mwb_woo_one_click_checkout_include_hidden_products' ).val();

      $.each( mwb_woocc_selected_include_products, function( key, value ){
				mwb_woocc_hidden_product_value.push( value );
			});

			$.each( mwb_woocc_selected_excluded_products, function( key, value ){
				mwb_woocc_hidden_product_value.push( value );
			});

      var mwb_woocc_array_pre_length = 0 ;
			$('#mwb_woo_one_click_checkout_include_hidden_products' ).val( mwb_woocc_hidden_product_value );

      if(mwb_woocc_previously_selected_product_value != null && mwb_woocc_previously_selected_product_value.length != null && mwb_woocc_previously_selected_product_value.length != 0){
				var mwb_woocc_array_pre_length = mwb_woocc_previously_selected_product_value.length;
			}

      var mwb_woocc_product_hidden_length = mwb_woocc_hidden_product_value.length;

      if( mwb_woocc_array_pre_length >= mwb_woocc_product_hidden_length ){
				var i = 0;
				$.grep(mwb_woocc_previously_selected_product_value, function(el) {
					if ($.inArray(el, mwb_woocc_hidden_product_value) == -1){
						var status_name = mwb_wocc_all_included_products[el];
						var  html = '<option value='+el+'>'+mwb_wocc_all_included_products_text[el]+'</option>';
						$('#mwb_woo_one_click_checkout_exclude_products').append( html );
					}
					i++;
				});
			}
			else if( mwb_woocc_array_pre_length <= mwb_woocc_product_hidden_length ){
				var i = 0;
				$.grep(mwb_woocc_hidden_product_value, function(el){
					if ($.inArray(el, mwb_woocc_previously_selected_product_value) == -1){
						$("#mwb_woo_one_click_checkout_exclude_products option[value="+el+"]").remove();
					}
					i++;
				});
			}

    });

    // =   JS for on change value in excluded product multiselect.  =
    $( document ).on( 'change', '#mwb_woo_one_click_checkout_exclude_products', function(){

      var mwb_woocc_hidden_product_value = [] ;
			var mwb_woocc_previously_selected_product_value = [];

			var mwb_woocc_selected_include_products         = $( '#mwb_woo_one_click_checkout_exclude_products' ).val();
			var mwb_woocc_selected_excluded_products        = $( '#mwb_woo_one_click_checkout_include_products' ).val();
			var mwb_woocc_previously_selected_product_value = $( '#mwb_woo_one_click_checkout_include_hidden_products' ).val();

      $.each( mwb_woocc_selected_include_products, function( key, value ){
				mwb_woocc_hidden_product_value.push( value );
			});

			$.each( mwb_woocc_selected_excluded_products, function( key, value ){
				mwb_woocc_hidden_product_value.push( value );
			});

      $( '#mwb_woo_one_click_checkout_include_hidden_products' ).val( mwb_woocc_hidden_product_value );

      var mwb_woocc_array_pre_length = 0 ;
			if(mwb_woocc_previously_selected_product_value != null && mwb_woocc_previously_selected_product_value.length != null && mwb_woocc_previously_selected_product_value.length != 0){
				var mwb_woocc_array_pre_length = mwb_woocc_previously_selected_product_value.length;
			}

      var mwb_woocc_product_hidden_length = mwb_woocc_hidden_product_value.length;
      if( mwb_woocc_array_pre_length >= mwb_woocc_product_hidden_length ){
				var i = 0;
				$.grep(mwb_woocc_previously_selected_product_value, function(el) {
					if ($.inArray(el, mwb_woocc_hidden_product_value) == -1){
						var status_name = mwb_wocc_all_included_products[el];
						var  html = '<option value='+el+'>'+mwb_wocc_all_included_products_text[el]+'</option>';
						$('#mwb_woo_one_click_checkout_include_products').append( html );
					}
					i++;
				});
			}
			else if( mwb_woocc_array_pre_length <= mwb_woocc_product_hidden_length ){
				var i = 0;
				$.grep(mwb_woocc_hidden_product_value, function(el) {
					if ($.inArray(el, mwb_woocc_previously_selected_product_value) == -1){
						$("#mwb_woo_one_click_checkout_include_products option[value="+el+"]").remove();
					}
					i++;
				});
			}
    });

  });

  $(window).on('load', function () {
    // add select2 for multiselect.
    if ($(document).find(".mwb-defaut-multiselect").length > 0) {
      $(document)
        .find(".mwb-defaut-multiselect")
        .select2();
    }
  });

})(jQuery);
