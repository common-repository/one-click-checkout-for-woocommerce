<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace one_click_checkout_for_woocommerce_common.
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/common
 */
class One_Click_Checkout_For_Woocommerce_Common {
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
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwocc_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'common/css/one-click-checkout-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwocc_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'common/js/one-click-checkout-for-woocommerce-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name . 'common',
			'mwocc_common_param',
			array(
				'ajaxurl'                        => admin_url( 'admin-ajax.php' ),
				'checkoutpage_url'               => get_permalink( get_option( 'woocommerce_checkout_page_id' ) ),
				'mwb_woo_one_click_checkout_msg' => __( 'Please Select Variation First', 'one-click-checkout-for-woocommerce' ),
				'nonce'                          => wp_create_nonce( 'mwb_woo_on_click_checkout_nonce_verfy' ),
			)
		);
		wp_enqueue_script( $this->plugin_name . 'common' );
	}

	/**
	 * This function is used to redirect user on cheeckout page.
	 *
	 * @return void
	 */
	public function mwocc_product_added_cart_redirect_checkout() {
		check_ajax_referer( 'mwb_woo_on_click_checkout_nonce_verfy', 'nonce' );
		if ( isset( $_POST ) ) {
			$mwb_woo_chckout_product_id = ! empty( $_POST['mwb_woo_chckout_product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_woo_chckout_product_id'] ) ) : '';
			if ( isset( $mwb_woo_chckout_product_id ) && ( '' !== $mwb_woo_chckout_product_id || null !== $mwb_woo_chckout_product_id ) ) {

				$product = wc_get_product( $mwb_woo_chckout_product_id );
				if ( isset( $product ) && ! empty( $product ) ) {

					if ( 'simple' === $product->get_type() || 'external' === $product->get_type() || 'grouped' === $product->get_type() ) {

						$productdata = $product->get_data();

						if ( is_array( $productdata ) && ! empty( $productdata ) ) {
							if ( 'no' === $productdata['backorders'] && 'instock' === $productdata['stock_status'] ) {

								WC()->cart->add_to_cart( $mwb_woo_chckout_product_id, 1 );
								wc_add_to_cart_message( array( $mwb_woo_chckout_product_id => 1 ), true );
								echo 'success';

							} elseif ( 'yes' === $productdata['backorders'] && 'instock' !== $productdata['stock_status'] ) {

								WC()->cart->add_to_cart( $mwb_woo_chckout_product_id, 1 );
								wc_add_to_cart_message( array( $mwb_woo_chckout_product_id => 1 ), true );
								echo 'success';

							} elseif ( 'yes' === $productdata['backorders'] && 'instock' === $productdata['stock_status'] ) {

								WC()->cart->add_to_cart( $mwb_woo_chckout_product_id, 1 );
								wc_add_to_cart_message( array( $mwb_woo_chckout_product_id => 1 ), true );
								echo 'success';

							} else {
								echo 'failed';
							}
						}
					} elseif ( 'variable' === $product->get_type() ) {

						$mwb_woo_variation_id = ! empty( $_POST['mwb_woo_variation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_woo_variation_id'] ) ) : '';
						// phpcs:ignore.
						$product_all_variations = $product->get_available_variations();

						if ( is_array( $product_all_variations ) && ! empty( $product_all_variations ) && ( '' !== $mwb_woo_variation_id || null !== $mwb_woo_variation_id ) ) {
							foreach ( $product_all_variations as $variation_key => $variation_value ) {

								if ( $variation_value['variation_id'] == $mwb_woo_variation_id ) {
									if ( 1 != $variation_value['backorders_allowed'] && 1 == $variation_value['is_in_stock'] ) {

										WC()->cart->add_to_cart( $mwb_woo_chckout_product_id, 1, $mwb_woo_variation_id, wc_get_product_variation_attributes( $mwb_woo_variation_id ) );
										wc_add_to_cart_message( array( $mwb_woo_chckout_product_id => 1 ), true );
										echo 'success';

									} elseif ( 1 == $variation_value['backorders_allowed'] && 1 != $variation_value['is_in_stock'] ) {

										WC()->cart->add_to_cart( $mwb_woo_chckout_product_id, 1, $mwb_woo_variation_id, wc_get_product_variation_attributes( $mwb_woo_variation_id ) );
										wc_add_to_cart_message( array( $mwb_woo_chckout_product_id => 1 ), true );
										echo 'success';

									} elseif ( 1 == $variation_value['backorders_allowed'] && 1 == $variation_value['is_in_stock'] ) {

										WC()->cart->add_to_cart( $mwb_woo_chckout_product_id, 1, $mwb_woo_variation_id, wc_get_product_variation_attributes( $mwb_woo_variation_id ) );
										wc_add_to_cart_message( array( $mwb_woo_chckout_product_id => 1 ), true );
										echo 'success';

									} else {
										echo 'failed';
									}
								}
							}
						}
					} else {

						echo 'failed';
					}
				} else {

					echo 'failed';
				}
			} else {

				echo 'failed';
			}
		}
		wp_die();
	}
}
