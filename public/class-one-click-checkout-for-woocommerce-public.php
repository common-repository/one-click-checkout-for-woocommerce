<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace one_click_checkout_for_woocommerce_public.
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/public
 */
class One_Click_Checkout_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwocc_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'public/css/one-click-checkout-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwocc_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'public/js/one-click-checkout-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'mwocc_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );
	}

	/**
	 * This function is used to show One-Click Checkout on Shop Page.
	 *
	 * @return void
	 */
	public function mwocc_add_one_click_checkout_button_on_shop_page() {

		if ( is_shop() ) {

			global $product;
			$mwb_button_back_color                       = get_option( 'mwb_occfw_checkout_button_back_color' );
			$mwb_button_text_color                       = get_option( 'mwb_occfw_checkout_button_text_color' );
			$mwb_button_text                             = get_option( 'mwb_occfw_checkout_button_name' );
			$mwb_woo_one_click_checkout_product_settings = get_option( 'mwb_woo_one_click_checkout_product_settings', array() );
			$mwb_woo_product_button_allowed              = array();

			if ( 'variable' !== $product->get_type() && is_array( $mwb_woo_one_click_checkout_product_settings ) ) {

				$mwb_woo_product_button_allowed[] = $this->mwocc_get_show_conditions_for_button( $mwb_woo_one_click_checkout_product_settings, $product, $mwb_woo_product_button_allowed );
			} elseif ( 'variable' !== $product->get_type() && ! is_array( $mwb_woo_one_click_checkout_product_settings ) ) {

				$mwb_woo_product_button_allowed[] = array( $product->get_id() );
			}

			if ( 'variable' === $product->get_type() ) {
				if ( is_array( $mwb_woo_one_click_checkout_product_settings ) ) {
					$mwb_woo_product_button_allowed[] = $this->mwocc_get_show_conditions_for_button( $mwb_woo_one_click_checkout_product_settings, $product, $mwb_woo_product_button_allowed );
				} else {
					$mwb_woo_product_button_allowed[] = array( $product->get_id() );
				}
			}

			if ( ! empty( $mwb_woo_product_button_allowed[0] ) && in_array( $product->get_id(), $mwb_woo_product_button_allowed[0] ) ) {
				?>
				<div class="mwb_woo_one_click_checkout_shop_wrapper">
					<input type="button" name="mwb_woo_one_click_checkout_user_button" id="mwb_woo_one_click_checkout_user_button" class="mwb_woo_one_click_checkout_user_buynow_shop button alt" 
					value="<?php
					if ( isset( $mwb_button_text ) && ( '' != $mwb_button_text || null != $mwb_button_text ) ) {
						echo esc_html( $mwb_button_text );
					} else {
						esc_html_e( 'Buy Now', 'one-click-checkout-for-woocommerce' ); }
					?>" 
					data-productId="<?php echo esc_attr( $product->get_id() ); ?>" data-productType="<?php echo esc_attr( $product->get_type() ); ?>">
					<input type="hidden" name="mwb_woo_text_and_background_color" class="mwb_woo_text_and_background_color" data-buttonbackgroundcolor="
					<?php
					if ( isset( $mwb_button_back_color ) && ( '' != $mwb_button_back_color || null != $mwb_button_back_color ) ) {
						echo esc_html( $mwb_button_back_color ); }
					?>
					" data-textcolor="
				<?php
				if ( isset( $mwb_button_text_color ) && ( '' != $mwb_button_text_color || null != $mwb_button_text_color ) ) {
						echo esc_html( $mwb_button_text_color ); }
				?>">
				</div>
				<?php
			}
		}
	}

	/**
	 * This function is used to One-Click Checkout button on Single Product Page.
	 *
	 * @return void
	 */
	public function mwocc_one_click_checkout_button_for_single_page() {

		if ( is_product() ) {

			global $product;
			$mwb_button_back_color                       = get_option( 'mwb_occfw_checkout_button_back_color' );
			$mwb_button_text_color                       = get_option( 'mwb_occfw_checkout_button_text_color' );
			$mwb_button_text                             = get_option( 'mwb_occfw_checkout_button_name' );
			$mwb_woo_one_click_checkout_product_settings = get_option( 'mwb_woo_one_click_checkout_product_settings', array() );
			$mwb_woo_product_button_allowed              = array();

			if ( isset( $product ) && ! empty( $product ) ) {
				?>
				<div class="mwb_woo_one_click_checkout_single_wrapper">
					<?php
					$product_data = $product->get_data();
					if ( 'simple' === $product->get_type() || 'external' === $product->get_type() || 'grouped' === $product->get_type() ) {

						if ( is_array( $mwb_woo_one_click_checkout_product_settings ) ) {

							$mwb_woo_product_button_allowed[] = $this->mwocc_get_show_conditions_for_button( $mwb_woo_one_click_checkout_product_settings, $product, $mwb_woo_product_button_allowed );
						} else {
							$mwb_woo_product_button_allowed[] = array( $product->get_id() );
						}

						if ( ! empty( $mwb_woo_product_button_allowed[0] ) && in_array( $product->get_id(), $mwb_woo_product_button_allowed[0] ) ) {
							?>
							<input type="button" name="mwb_woo_one_click_checkout_user_button" id="mwb_woo_one_click_checkout_user_button" class="mwb_woo_one_click_checkout_user_buynow_single button alt" 
							value="<?php
							if ( isset( $mwb_button_text ) && ( '' != $mwb_button_text || null != $mwb_button_text ) ) {
								echo esc_html( $mwb_button_text );
							} else {
								esc_html_e( 'Buy Now', 'one-click-checkout-for-woocommerce' ); }
							?>"
							data-productId="<?php echo esc_html( $product->get_id() ); ?>" data-productType="<?php echo esc_html( $product->get_type() ); ?> ">
							<input type="hidden" name="mwb_woo_text_and_background_color" class="mwb_woo_text_and_background_color" data-buttonbackgroundcolor="
							<?php
							if ( isset( $mwb_button_back_color ) && ( '' != $mwb_button_back_color || null != $mwb_button_back_color ) ) {
								echo esc_html( $mwb_button_back_color ); }
							?>
							" data-textcolor="
							<?php
							if ( isset( $mwb_button_text_color ) && ( '' != $mwb_button_text_color || null != $mwb_button_text_color ) ) {
								echo esc_html( $mwb_button_text_color ); }
							?>
							">
							<?php
						}
					} elseif ( 'variable' === $product->get_type() ) {

						if ( is_array( $mwb_woo_one_click_checkout_product_settings ) ) {
							$mwb_woo_product_button_allowed[] = $this->mwocc_get_show_conditions_for_button( $mwb_woo_one_click_checkout_product_settings, $product, $mwb_woo_product_button_allowed );
						} else {
							$mwb_woo_product_button_allowed[] = array( $product->get_id() );
						}
						if ( ! empty( $mwb_woo_product_button_allowed[0] ) && in_array( $product->get_id(), $mwb_woo_product_button_allowed[0] ) ) {
							?>
							<input type="button" name="mwb_woo_one_click_checkout_user_button" id="mwb_woo_one_click_checkout_user_button" class="mwb_woo_one_click_checkout_user_buynow_single_variable button alt" 
							value="<?php
							if ( isset( $mwb_button_text ) && ( '' != $mwb_button_text || null != $mwb_button_text ) ) {
								echo esc_html( $mwb_button_text );
							} else {
								esc_html_e( 'Buy Now', 'one-click-checkout-for-woocommerce' ); }
							?>"
							data-productId="<?php echo esc_html( $product->get_id() ); ?>" data-productType="<?php echo esc_html( $product->get_type() ); ?> ">
							<input type="hidden" name="mwb_woo_text_and_background_color" class="mwb_woo_text_and_background_color" data-buttonbackgroundcolor="
							<?php
							if ( isset( $mwb_button_back_color ) && ( '' != $mwb_button_back_color || null != $mwb_button_back_color ) ) {
								echo esc_html( $mwb_button_back_color ); }
							?>
							" data-textcolor="
							<?php
							if ( isset( $mwb_button_text_color ) && ( '' != $mwb_button_text_color || null != $mwb_button_text_color ) ) {
								echo esc_html( $mwb_button_text_color ); }
							?>">
							<?php
						}
						?>
					</div>
						<?php
					}
			}
		}
	}

	/**
	 * Function for showing variations selection alert message on single page.
	 *
	 * @return void
	 */
	public function mwocc_one_click_checkout_error_message() {
		global $product;
		if ( isset( $product ) && ! empty( $product ) ) {

			if ( 'variable' === $product->get_type() ) {
				?>
				<div id="mwb_wocc_variable_product_error_message"></div>
				<?php
			}
		}
	}

	/**
	 * This function is used to set condition on button.
	 * You can show checkout button according to product option settings.
	 *
	 * @param [array]  $mwb_woo_one_click_checkout_product_settings contain array.
	 * @param [object] $product contain object.
	 * @param [array]  $mwb_woo_product_button_allowed contain array.
	 * @return array
	 */
	public function mwocc_get_show_conditions_for_button( $mwb_woo_one_click_checkout_product_settings, $product, $mwb_woo_product_button_allowed ) {

		if ( isset( $product ) && ! empty( $product ) ) {
			$mwb_product_data = $product->get_data();
		}

		if ( ( isset( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && ! isset( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) || ( ! isset( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && isset( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) || ( isset( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && isset( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) ) {

			if ( ( isset( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['included_product'] ) ) && ( ! isset( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && empty( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) ) {

				if ( in_array( $product->get_id(), $mwb_woo_one_click_checkout_product_settings['included_product'] ) ) {
					$mwb_woo_product_button_allowed[] = $product->get_id();

				} elseif ( isset( $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {
					$terms = get_the_terms( $mwb_product_data['id'], 'product_cat' );
					if ( isset( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $termvalue ) {
							if ( in_array( $termvalue->term_id, $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {

								$mwb_woo_product_button_allowed[] = $product->get_id();

							}
						}
					}
				} else {
					$mwb_woo_product_button_allowed[] = '';
				}

				return $mwb_woo_product_button_allowed;

			} elseif ( ( ! isset( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && empty( $mwb_woo_one_click_checkout_product_settings['included_product'] ) ) && ( isset( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) ) {

				if ( ! in_array( $product->get_id(), $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && ( ! isset( $mwb_woo_one_click_checkout_product_settings['categories'] ) ) ) {

					$mwb_woo_product_button_allowed[] = $product->get_id();

				} elseif ( isset( $mwb_woo_one_click_checkout_product_settings['categories'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {
					$excludedterms = get_the_terms( $product->get_id(), 'product_cat' );
					if ( is_array( $excludedterms ) && ! empty( $excludedterms ) ) {
						foreach ( $excludedterms as $excludedkey => $excludedvalues ) {
							if ( ! in_array( $product->get_id(), $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && in_array( $excludedvalues->term_id, $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {

								$mwb_woo_product_button_allowed[] = $product->get_id();
							}
						}
					}
				}

				return $mwb_woo_product_button_allowed;
			} elseif ( ( is_array( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['included_product'] ) ) && ( is_array( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) ) {

				if ( in_array( $product->get_id(), $mwb_woo_one_click_checkout_product_settings['included_product'] ) ) {

					$mwb_woo_product_button_allowed[] = $product->get_id();

				} elseif ( is_array( $mwb_woo_one_click_checkout_product_settings['categories'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {

					$product_term = get_the_terms( $product->get_id(), 'product_cat' );

					if ( isset( $product_term ) && ! empty( $product_term ) ) {
						foreach ( $product_term as $product_term_key => $product_term_value ) {
							if ( in_array( $product_term_value->term_id, $mwb_woo_one_click_checkout_product_settings['categories'] ) && ! in_array( $product->get_id(), $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) {

								$mwb_woo_product_button_allowed[] = $product->get_id();
							}
						}
					}
				}
				return $mwb_woo_product_button_allowed;
			}
		} elseif ( ( ! isset( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && ! isset( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) ) {

			if ( isset( $mwb_woo_one_click_checkout_product_settings['categories'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['categories'] ) && ! empty( $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {

				$categoryterms = get_the_terms( $product->get_id(), 'product_cat' );
				if ( isset( $categoryterms ) && ! empty( $categoryterms ) ) {
					foreach ( $categoryterms as $catkey => $catvalue ) {
						if ( in_array( $catvalue->term_id, $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {

							$mwb_woo_product_button_allowed[] = $product->get_id();
						}
					}
				}
			} else {
				$mwb_woo_product_button_allowed[] = $product->get_id();
			}
		}
		return $mwb_woo_product_button_allowed;
	}

	/**
	 * This function is used to get order id from thank you page.
	 *
	 * @param [intger] $order_id contain order id.
	 * @return void
	 */
	public function mwocc_guest_details( $order_id ) {

		if ( ! is_user_logged_in() ) {

			if ( isset( $order_id ) ) {

				$mwb_cookie_time   = get_option( 'mwb_woo_one_click_checkout_cookie_time' );
				$mwb_cookie_method = get_option( 'mwb_woo_one_click_checkout_cookie_method' );

				$order      = wc_get_order( $order_id );
				$order_data = $order->get_data();

				$mwb_wocc_guest_user_all_data = array(
					'mwb_wocc_user_order_id'         => $order->get_id(),
					'mwb_wocc_user_billing_address'  => $order_data['billing'],
					'mwb_wocc_user_shipping_address' => $order_data['shipping'],
					'mwb_wocc_payment_method_used'   => $order_data['payment_method'],
				);

				if ( ! isset( $_COOKIE['mwb_wocc_user_cookie'] ) ) {

					if ( isset( $mwb_cookie_method ) && 'day' === $mwb_cookie_method ) {

						if ( isset( $mwb_cookie_time ) && ( '' != $mwb_cookie_time || null != $mwb_cookie_time ) ) {

							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * $mwb_cookie_time ), '/' );
						} else {
							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * 365 ), '/' );
						}
					} elseif ( isset( $mwb_cookie_method ) && 'week' === $mwb_cookie_method ) {

						if ( isset( $mwb_cookie_time ) && ( '' != $mwb_cookie_time || null != $mwb_cookie_time ) ) {

							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * ( 7 * $mwb_cookie_time ) ), '/' );

						} else {
							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * 365 ), '/' );
						}
					} elseif ( isset( $mwb_cookie_method ) && 'month' === $mwb_cookie_method ) {

						if ( isset( $mwb_cookie_time ) && ( '' != $mwb_cookie_time || null != $mwb_cookie_time ) ) {

							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * ( 30 * $mwb_cookie_time ) ), '/' );

						} else {
							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * 365 ), '/' );
						}
					} elseif ( isset( $mwb_cookie_method ) && 'year' === $mwb_cookie_method ) {

						if ( isset( $mwb_cookie_time ) && ( '' != $mwb_cookie_time || null != $mwb_cookie_time ) ) {

							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * ( 365 * $mwb_cookie_time ) ), '/' );

						} else {
							setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * 365 ), '/' );
						}
					} else {
						setcookie( 'mwb_wocc_user_cookie', wp_json_encode( maybe_serialize( $mwb_wocc_guest_user_all_data ) ), time() + ( 86400 * 365 ), '/' );
					}
				}
			}
		}
	}

	/**
	 * Function for auto fill guest details on checkout fields using cookies details.
	 *
	 * @param [array] $fields contain billing details.
	 * @return array
	 */
	public function mwocc_autofill_checkoutpage_for_guest_user( $fields ) {
		if ( ! is_user_logged_in() && is_checkout() && isset( $_COOKIE['mwb_wocc_user_cookie'] ) ) {

			$mwb_wocc_guest_user_order_details = ! empty( $_COOKIE['mwb_wocc_user_cookie'] ) ? maybe_unserialize( map_deep( json_decode( sanitize_text_field( wp_unslash( $_COOKIE['mwb_wocc_user_cookie'] ) ) ), 'sanitize_text_field' ) ) : '';

			if ( is_array( $mwb_wocc_guest_user_order_details ) && ! empty( $mwb_wocc_guest_user_order_details ) ) {

				// billing details.
				$fields['billing']['billing_first_name']['default'] = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['first_name'];
				$fields['billing']['billing_last_name']['default']  = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['last_name'];
				$fields['billing']['billing_company']['default']    = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['company'];
				$fields['billing']['billing_country']['default']    = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['country'];
				$fields['billing']['billing_address_1']['default']  = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['address_1'];
				$fields['billing']['billing_address_1']['default']  = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['address_2'];
				$fields['billing']['billing_city']['default']       = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['city'];
				$fields['billing']['billing_state']['default']      = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['state'];
				$fields['billing']['billing_postcode']['default']   = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['postcode'];
				$fields['billing']['billing_phone']['default']      = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['phone'];
				$fields['billing']['billing_email']['default']      = $mwb_wocc_guest_user_order_details['mwb_wocc_user_billing_address']['email'];

				// Shipping same as billing.
				$fields['shipping']['shipping_first_name']['default'] = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['first_name'];
				$fields['shipping']['shipping_last_name']['default']  = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['last_name'];
				$fields['shipping']['shipping_company']['default']    = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['company'];
				$fields['shipping']['shipping_country']['default']    = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['country'];
				$fields['shipping']['shipping_address_1']['default']  = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['address_1'];
				$fields['shipping']['shipping_address_1']['default']  = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['address_2'];
				$fields['shipping']['shipping_city']['default']       = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['city'];
				$fields['shipping']['shipping_state']['default']      = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['state'];
				$fields['shipping']['shipping_postcode']['default']   = $mwb_wocc_guest_user_order_details['mwb_wocc_user_shipping_address']['postcode'];

				return $fields;
			}
		} else {
			return $fields;
		}
	}
}
