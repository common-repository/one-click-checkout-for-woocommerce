<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/admin
 */
class One_Click_Checkout_For_Woocommerce_Admin {


	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function mwocc_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_one_click_checkout_for_woocommerce_menu' === $screen->id ) {

			wp_enqueue_style( 'mwb-occfw-select2-css', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/one-click-checkout-for-woocommerce-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-occfw-meterial-css', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-occfw-meterial-css2', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-occfw-meterial-lite', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-occfw-meterial-icons-css', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-admin-global', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/one-click-checkout-for-woocommerce-admin-global.css', array( 'mwb-occfw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/one-click-checkout-for-woocommerce-admin.scss', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-admin-min-css', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-datatable-css', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/datatables/media/css/jquery.dataTables.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wp-color-picker' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function mwocc_admin_enqueue_scripts( $hook ) {

		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_one_click_checkout_for_woocommerce_menu' === $screen->id ) {
			wp_enqueue_script( 'mwb-occfw-select2', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/one-click-checkout-for-woocommerce-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'mwb-occfw-metarial-js', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-occfw-metarial-js2', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-occfw-metarial-lite', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );

			wp_register_script( $this->plugin_name . 'admin-js', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/one-click-checkout-for-woocommerce-admin.js', array( 'jquery', 'wp-color-picker', 'mwb-occfw-select2', 'mwb-occfw-metarial-js', 'mwb-occfw-metarial-js2', 'mwb-occfw-metarial-lite' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'mwocc_admin_param',
				array(
					'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
					'mwb_standard_nonce'         => wp_create_nonce( 'ajax-nonce' ),
					'reloadurl'                  => admin_url( 'admin.php?page=one_click_checkout_for_woocommerce_menu' ),
					'mwocc_gen_tab_enable'       => get_option( 'mwocc_radio_switch_demo' ),
					'mwocc_admin_param_location' => ( admin_url( 'admin.php' ) . '?page=one_click_checkout_for_woocommerce_menu&mwocc_tab=one-click-checkout-for-woocommerce-general' ),
				)
			);
			wp_enqueue_script( $this->plugin_name . 'admin-js' );
			wp_enqueue_script( 'mwb-admin-min-js', ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-admin.min.js', array(), time(), false );
		}
	}

	/**
	 * Adding settings menu for One Click Checkout For WooCommerce.
	 *
	 * @since 1.0.0
	 */
	public function mwocc_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( 'MakeWebBetter', 'MakeWebBetter', 'manage_options', 'mwb-plugins', array( $this, 'mwocc_plugins_listing_page' ), ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/MWB_Grey-01.svg', 15 );
			$mwocc_menus =
			// desc - filter for trial.
			apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $mwocc_menus ) && ! empty( $mwocc_menus ) ) {
				foreach ( $mwocc_menus as $mwocc_key => $mwocc_value ) {
					add_submenu_page( 'mwb-plugins', $mwocc_value['name'], $mwocc_value['name'], 'manage_options', $mwocc_value['menu_link'], array( $mwocc_value['instance'], $mwocc_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since 1.0.0
	 */
	public function mwocc_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}


	/**
	 * One Click Checkout For WooCommerce mwocc_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function mwocc_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'One Click Checkout For WooCommerce', 'one-click-checkout-for-woocommerce' ),
			'slug'      => 'one_click_checkout_for_woocommerce_menu',
			'menu_link' => 'one_click_checkout_for_woocommerce_menu',
			'instance'  => $this,
			'function'  => 'mwocc_options_menu_html',
		);
		return $menus;
	}

	/**
	 * One Click Checkout For WooCommerce mwocc_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwocc_plugins_listing_page() {
		$active_marketplaces =
		// desc - filter for trial.
		apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			include ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * One Click Checkout For WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 */
	public function mwocc_options_menu_html() {

		include_once ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/one-click-checkout-for-woocommerce-admin-dashboard.php';
	}

	/**
	 * Developer_admin_hooks_listing
	 *
	 * @name mwocc_developer_admin_hooks_listing
	 */
	public function mwocc_developer_admin_hooks_listing() {
		$admin_hooks = array();
		$val         = self::mwocc_developer_hooks_function( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/' );
		if ( ! empty( $val['hooks'] ) ) {
			$admin_hooks[] = $val['hooks'];
			unset( $val['hooks'] );
		}
		$data = array();
		foreach ( $val['files'] as $v ) {
			if ( 'css' !== $v && 'js' !== $v && 'images' !== $v ) {
				$helo = self::mwocc_developer_hooks_function( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/' . $v . '/' );
				if ( ! empty( $helo['hooks'] ) ) {
					$admin_hooks[] = $helo['hooks'];
					unset( $helo['hooks'] );
				}
				if ( ! empty( $helo ) ) {
					$data[] = $helo;
				}
			}
		}
		return $admin_hooks;
	}

	/**
	 * Developer_public_hooks_listing
	 */
	public function mwocc_developer_public_hooks_listing() {

		$public_hooks = array();
		$val          = self::mwocc_developer_hooks_function( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'public/' );

		if ( ! empty( $val['hooks'] ) ) {
			$public_hooks[] = $val['hooks'];
			unset( $val['hooks'] );
		}
		$data = array();
		foreach ( $val['files'] as $v ) {
			if ( 'css' !== $v && 'js' !== $v && 'images' !== $v ) {
				$helo = self::mwocc_developer_hooks_function( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'public/' . $v . '/' );
				if ( ! empty( $helo['hooks'] ) ) {
					$public_hooks[] = $helo['hooks'];
					unset( $helo['hooks'] );
				}
				if ( ! empty( $helo ) ) {
					$data[] = $helo;
				}
			}
		}
		return $public_hooks;
	}
	/**
	 * Developer_hooks_function
	 *
	 * @name mwocc_developer_hooks_function
	 * @param string $path Path of the file.
	 */
	public function mwocc_developer_hooks_function( $path ) {
		$all_hooks = array();
		$scan      = scandir( $path );
		$response  = array();
		foreach ( $scan as $file ) {
			if ( strpos( $file, '.php' ) ) {
				$myfile = file( $path . $file );
				foreach ( $myfile as $key => $lines ) {
					if ( preg_match( '/do_action/i', $lines ) && ! strpos( $lines, 'str_replace' ) && ! strpos( $lines, 'preg_match' ) ) {
						$all_hooks[ $key ]['action_hook'] = $lines;
						$all_hooks[ $key ]['desc']        = $myfile[ $key - 1 ];
					}
					if ( preg_match( '/apply_filters/i', $lines ) && ! strpos( $lines, 'str_replace' ) && ! strpos( $lines, 'preg_match' ) ) {
						$all_hooks[ $key ]['filter_hook'] = $lines;
						$all_hooks[ $key ]['desc']        = $myfile[ $key - 1 ];
					}
				}
			} elseif ( strpos( $file, '.' ) == '' && strpos( $file, '.' ) !== 0 ) {
				$response['files'][] = $file;
			}
		}
		if ( ! empty( $all_hooks ) ) {
			$response['hooks'] = $all_hooks;
		}
		return $response;
	}

	/**
	 * This function is used to save product option settings data.
	 *
	 * @return void
	 */
	public function mwocc_product_option_setting() {

		global $mwocc_mwb_occfw_obj;
		$mwb_occfw_gen_flag = false;

		if ( isset( $_POST['mwb_woo_one_click_checkout_product_option_nonce'] ) ) {
			$mwb_woo_one_click_checkout_product_option_nonce = ! empty( $_POST['mwb_woo_one_click_checkout_product_option_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_woo_one_click_checkout_product_option_nonce'] ) ) : '';
			if ( wp_verify_nonce( $mwb_woo_one_click_checkout_product_option_nonce, 'mwb-woo-one-click-product-nonce' ) ) {
				if ( isset( $_POST['mwb_woo_one_click_checkout_product_option_setting_submit'] ) ) {

					$mwb_woo_one_click_checkout_product_settings = ! empty( $_POST['mwb_woo_one_click_checkout_product_settings'] ) ? ( is_array( $_POST['mwb_woo_one_click_checkout_product_settings'] ) ? map_deep( wp_unslash( $_POST['mwb_woo_one_click_checkout_product_settings'] ), 'sanitize_text_field' ) : sanitize_text_field( wp_unslash( $_POST['mwb_woo_one_click_checkout_product_settings'] ) ) ) : array();
					update_option( 'mwb_woo_one_click_checkout_product_settings', $mwb_woo_one_click_checkout_product_settings );
					$mwb_occfw_gen_flag = true;
				}
			}
		}
		if ( $mwb_occfw_gen_flag ) {
			$mwb_occfw_error_text = esc_html__( 'Settings saved !', 'one-click-checkout-for-woocommerce' );
			$mwocc_mwb_occfw_obj->mwocc_plug_admin_notice( $mwb_occfw_error_text, 'success' );
		}
	}

	/**
	 * One Click Checkout For WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $mwocc_settings_general Settings fields.
	 */
	public function mwocc_admin_general_settings_page( $mwocc_settings_general ) {

		$mwocc_settings_general = array(
			array(
				'title'       => __( 'Enable plugin', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable plugin to start the functionality.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_occfw_enable_one_click_checkout',
				'value'       => get_option( 'mwb_occfw_enable_one_click_checkout' ),
				'class'       => 'mwocc-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'one-click-checkout-for-woocommerce' ),
					'no'  => __( 'NO', 'one-click-checkout-for-woocommerce' ),
				),
			),

			array(
				'title'       => __( 'Show Checkout Button On Shop Page', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'checkbox',
				'description' => __( 'Show One-Click Checkout Button on Shop Page.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_occfw_show_chekout_button_shop_page',
				'value'       => get_option( 'mwb_occfw_show_chekout_button_shop_page', '1' ),
				'class'       => 'mwocc-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'one-click-checkout-for-woocommerce' ),
			),

			array(
				'title'       => __( 'Show Checkout Button On Single Page', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'checkbox',
				'description' => __( 'Show One-Click Checkout Button On Single Page.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_occfw_show_chekout_button_single_page',
				'value'       => get_option( 'mwb_occfw_show_chekout_button_single_page' ),
				'class'       => 'mwocc-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'one-click-checkout-for-woocommerce' ),
			),

			array(
				'title'       => __( 'Select Checkout Button Background Color', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Select One-Click Checkout Button Background Color', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_occfw_checkout_button_back_color',
				'value'       => get_option( 'mwb_occfw_checkout_button_back_color' ),
				'class'       => 'mwocc-text-class',
				'placeholder' => __( 'Text Demo', 'one-click-checkout-for-woocommerce' ),
			),

			array(
				'title'       => __( 'Select Checkout Button Text Color', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Select One-Click Checkout Button Text Color', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_occfw_checkout_button_text_color',
				'value'       => get_option( 'mwb_occfw_checkout_button_text_color' ),
				'class'       => 'mwocc-text-class',
				'placeholder' => __( 'Text Demo', 'one-click-checkout-for-woocommerce' ),
			),

			array(
				'title'       => __( 'Enter Checkout Button Name', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter One-Click Checkout Button Text.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_occfw_checkout_button_name',
				'value'       => ! empty( get_option( 'mwb_occfw_checkout_button_name' ) ) ? get_option( 'mwb_occfw_checkout_button_name' ) : __( 'Buy Now', 'one-click-checkout-for-woocommerce' ),
				'class'       => 'mwocc-text-class',
				'placeholder' => __( 'Enter Button Name', 'one-click-checkout-for-woocommerce' ),
			),

			array(
				'title'       => __( 'Select Time Frame For Cookies Save Data', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwb_select_and_text',
				'type'        => 'select_and_text',
				'description' => __( 'Select Time Frame to save customer data within estimated time.', 'one-click-checkout-for-woocommerce' ),
				'value'       => array(
					array(
						'type'        => 'text',
						'id'          => 'mwb_woo_one_click_checkout_cookie_time',
						'value'       => get_option( 'mwb_woo_one_click_checkout_cookie_time' ),
						'class'       => 'mwocc-text-class',
						'placeholder' => __( 'Enter Number', 'one-click-checkout-for-woocommerce' ),
					),
					array(
						'type'    => 'select',
						'id'      => 'mwb_woo_one_click_checkout_cookie_method',
						'value'   => get_option( 'mwb_woo_one_click_checkout_cookie_method' ),
						'class'   => 'mwocc-select-class',
						'options' => array(
							''      => __( 'Select option', 'one-click-checkout-for-woocommerce' ),
							'day'   => __( 'Days', 'one-click-checkout-for-woocommerce' ),
							'week'  => __( 'Weeks', 'one-click-checkout-for-woocommerce' ),
							'month' => __( 'Months', 'one-click-checkout-for-woocommerce' ),
							'year'  => __( 'Years', 'one-click-checkout-for-woocommerce' ),
						),
					),
				),
			),

			array(
				'type'        => 'button',
				'id'          => 'mwocc_general_button',
				'button_text' => __( 'Save Changes', 'one-click-checkout-for-woocommerce' ),
				'class'       => 'mwocc-button-class',
			),
		);
		return $mwocc_settings_general;
	}

	/**
	 * One Click Checkout For WooCommerce admin menu page.
	 *
	 * @since 1.0.0
	 * @param array $mwocc_settings_template Settings fields.
	 */
	public function mwocc_admin_template_settings_page( $mwocc_settings_template ) {
		$mwocc_settings_template = array(
			array(
				'title'       => __( 'Text Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'This is text field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_text_demo',
				'value'       => '',
				'class'       => 'mwocc-text-class',
				'placeholder' => __( 'Text Demo', 'one-click-checkout-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Number Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'number',
				'description' => __( 'This is number field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_number_demo',
				'value'       => '',
				'class'       => 'mwocc-number-class',
				'placeholder' => '',
			),
			array(
				'title'       => __( 'Password Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'password',
				'description' => __( 'This is password field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_password_demo',
				'value'       => '',
				'class'       => 'mwocc-password-class',
				'placeholder' => '',
			),
			array(
				'title'       => __( 'Textarea Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'This is textarea field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_textarea_demo',
				'value'       => '',
				'class'       => 'mwocc-textarea-class',
				'rows'        => '5',
				'cols'        => '10',
				'placeholder' => __( 'Textarea Demo', 'one-click-checkout-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Select Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'select',
				'description' => __( 'This is select field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_select_demo',
				'value'       => '',
				'class'       => 'mwocc-select-class',
				'placeholder' => __( 'Select Demo', 'one-click-checkout-for-woocommerce' ),
				'options'     => array(
					''    => __( 'Select option', 'one-click-checkout-for-woocommerce' ),
					'INR' => __( 'Rs.', 'one-click-checkout-for-woocommerce' ),
					'USD' => __( '$', 'one-click-checkout-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Multiselect Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'multiselect',
				'description' => __( 'This is multiselect field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_multiselect_demo',
				'value'       => '',
				'class'       => 'mwocc-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options'     => array(
					'default' => __( 'Select currency code from options', 'one-click-checkout-for-woocommerce' ),
					'INR'     => __( 'Rs.', 'one-click-checkout-for-woocommerce' ),
					'USD'     => __( '$', 'one-click-checkout-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Checkbox Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'checkbox',
				'description' => __( 'This is checkbox field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_checkbox_demo',
				'value'       => '',
				'class'       => 'mwocc-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'one-click-checkout-for-woocommerce' ),
			),

			array(
				'title'       => __( 'Radio Field Demo', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'radio',
				'description' => __( 'This is radio field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_radio_demo',
				'value'       => '',
				'class'       => 'mwocc-radio-class',
				'placeholder' => __( 'Radio Demo', 'one-click-checkout-for-woocommerce' ),
				'options'     => array(
					'yes' => __( 'YES', 'one-click-checkout-for-woocommerce' ),
					'no'  => __( 'NO', 'one-click-checkout-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable', 'one-click-checkout-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'This is switch field demo follow same structure for further use.', 'one-click-checkout-for-woocommerce' ),
				'id'          => 'mwocc_radio_switch_demo',
				'value'       => '',
				'class'       => 'mwocc-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'one-click-checkout-for-woocommerce' ),
					'no'  => __( 'NO', 'one-click-checkout-for-woocommerce' ),
				),
			),

			array(
				'type'        => 'button',
				'id'          => 'mwocc_button_demo',
				'button_text' => __( 'Button Demo', 'one-click-checkout-for-woocommerce' ),
				'class'       => 'mwocc-button-class',
			),
		);
		return $mwocc_settings_template;
	}

	/**
	 * One Click Checkout For WooCommerce save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwocc_admin_save_tab_settings() {
		global $mwocc_mwb_occfw_obj;
		if ( isset( $_POST['mwocc_general_button'] ) && ( ! empty( $_POST['mwb_tabs_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb_tabs_nonce'] ) ), 'admin_save_data' ) ) ) {
			$mwb_occfw_gen_flag     = false;
			$mwocc_genaral_settings =
			// desc - filter for trial.
			apply_filters( 'mwocc_general_settings_array', array() );
			$mwocc_button_index = array_search( 'submit', array_column( $mwocc_genaral_settings, 'type' ) );
			if ( isset( $mwocc_button_index ) && ( null == $mwocc_button_index || '' == $mwocc_button_index ) ) {
				$mwocc_button_index = array_search( 'button', array_column( $mwocc_genaral_settings, 'type' ) );
			}
			if ( isset( $mwocc_button_index ) && '' !== $mwocc_button_index ) {
				unset( $mwocc_genaral_settings[ $mwocc_button_index ] );
				if ( is_array( $mwocc_genaral_settings ) && ! empty( $mwocc_genaral_settings ) ) {
					foreach ( $mwocc_genaral_settings as $mwocc_genaral_setting ) {
						if ( isset( $mwocc_genaral_setting['id'] ) && '' !== $mwocc_genaral_setting['id'] ) {
							if ( 'select_and_text' === $mwocc_genaral_setting['type'] ) {
								foreach ( $mwocc_genaral_setting['value'] as $sub_mwocc_genaral_setting ) {
									if ( isset( $_POST[ $sub_mwocc_genaral_setting['id'] ] ) ) {
										update_option( $sub_mwocc_genaral_setting['id'], is_array( $_POST[ $sub_mwocc_genaral_setting['id'] ] ) ? map_deep( wp_unslash( $_POST[ $sub_mwocc_genaral_setting['id'] ] ), 'sanitize_text_field' ) : sanitize_text_field( wp_unslash( $_POST[ $sub_mwocc_genaral_setting['id'] ] ) ) );
									} else {
										update_option( $sub_mwocc_genaral_setting['id'], '' );
									}
								}
								continue;
							}
							if ( isset( $_POST[ $mwocc_genaral_setting['id'] ] ) ) {
								update_option( $mwocc_genaral_setting['id'], is_array( $_POST[ $mwocc_genaral_setting['id'] ] ) ? map_deep( wp_unslash( $_POST[ $mwocc_genaral_setting['id'] ] ), 'sanitize_text_field' ) : sanitize_text_field( wp_unslash( $_POST[ $mwocc_genaral_setting['id'] ] ) ) );
							} else {
								update_option( $mwocc_genaral_setting['id'], '' );
							}
						} else {
							$mwb_occfw_gen_flag = true;
						}
					}
				}
				if ( $mwb_occfw_gen_flag ) {
					$mwb_occfw_error_text = esc_html__( 'Id of some field is missing', 'one-click-checkout-for-woocommerce' );
					$mwocc_mwb_occfw_obj->mwocc_plug_admin_notice( $mwb_occfw_error_text, 'error' );
				} else {
					$mwb_occfw_error_text = esc_html__( 'Settings saved !', 'one-click-checkout-for-woocommerce' );
					$mwocc_mwb_occfw_obj->mwocc_plug_admin_notice( $mwb_occfw_error_text, 'success' );
				}
			}
		}
	}

	/**
	 * Sanitation for an array
	 *
	 * @param mixed $mwb_input_array for array value.
	 *
	 * @return array
	 */
	public function mwocc_sanitize_array( $mwb_input_array ) {
		foreach ( $mwb_input_array as $key => $value ) {
			$key   = sanitize_text_field( $key );
			$value = sanitize_text_field( $value );
		}
		return $mwb_input_array;
	}
}
