<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/includes
 */
class One_Click_Checkout_For_Woocommerce {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 1.0.0
	 * @var   One_Click_Checkout_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $mwocc_onboard    To initializsed the object of class onboard.
	 */
	protected $mwocc_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( defined( 'ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_VERSION' ) ) {

			$this->version = ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'one-click-checkout-for-woocommerce';

		$this->mwocc_woocommerce_one_click_checkout_dependencies();
		$this->mwocc_woocommerce_one_click_checkout_locale();
		if ( is_admin() ) {
			$this->mwocc_woocommerce_one_click_checkout_admin_hooks();
		} else {
			$this->mwocc_woocommerce_one_click_checkout_public_hooks();
		}
		$this->mwocc_woocommerce_one_click_checkout_common_hooks();

		$this->mwocc_woocommerce_one_click_checkout_api_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - One_Click_Checkout_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - One_Click_Checkout_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - One_Click_Checkout_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - One_Click_Checkout_For_Woocommerce_Common. Defines all hooks for the common area.
	 * - One_Click_Checkout_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 1.0.0
	 */
	private function mwocc_woocommerce_one_click_checkout_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-one-click-checkout-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-one-click-checkout-for-woocommerce-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-one-click-checkout-for-woocommerce-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if ( is_dir( plugin_dir_path( dirname( __FILE__ ) ) . 'onboarding' ) && ! class_exists( 'One_Click_Checkout_For_Woocommerce_Onboarding_Steps' ) ) {
				include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-one-click-checkout-for-woocommerce-onboarding-steps.php';
			}

			if ( class_exists( 'One_Click_Checkout_For_Woocommerce_Onboarding_Steps' ) ) {
				$mwocc_onboard_steps = new One_Click_Checkout_For_Woocommerce_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-one-click-checkout-for-woocommerce-public.php';

		}

		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-one-click-checkout-for-woocommerce-rest-api.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-one-click-checkout-for-woocommerce-common.php';

		$this->loader = new One_Click_Checkout_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the One_Click_Checkout_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 1.0.0
	 */
	private function mwocc_woocommerce_one_click_checkout_locale() {

		$plugin_i18n = new One_Click_Checkout_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Define the name of the hook to save admin notices for this plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwb_saved_notice_hook_name() {
		$mwb_plugin_name                            = ! empty( explode( '/', plugin_basename( __FILE__ ) ) ) ? explode( '/', plugin_basename( __FILE__ ) )[0] : '';
		$mwb_plugin_settings_saved_notice_hook_name = $mwb_plugin_name . '_settings_saved_notice';
		return $mwb_plugin_settings_saved_notice_hook_name;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwocc_woocommerce_one_click_checkout_admin_hooks() {
		$mwocc_plugin_admin = new One_Click_Checkout_For_Woocommerce_Admin( $this->mwocc_get_plugin_name(), $this->mwocc_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $mwocc_plugin_admin, 'mwocc_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $mwocc_plugin_admin, 'mwocc_admin_enqueue_scripts' );

		// Add settings menu for One Click Checkout For WooCommerce.
		$this->loader->add_action( 'admin_menu', $mwocc_plugin_admin, 'mwocc_options_page' );
		$this->loader->add_action( 'admin_menu', $mwocc_plugin_admin, 'mwocc_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $mwocc_plugin_admin, 'mwocc_admin_submenu_page', 15 );
		$this->loader->add_filter( 'mwocc_general_settings_array', $mwocc_plugin_admin, 'mwocc_admin_general_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'mwb_occfw_settings_saved_notice', $mwocc_plugin_admin, 'mwocc_admin_save_tab_settings' );

		// Developer's Hook Listing.
		$this->loader->add_action( 'mwocc_developer_admin_hooks_array', $mwocc_plugin_admin, 'mwocc_developer_admin_hooks_listing' );
		$this->loader->add_action( 'mwocc_developer_public_hooks_array', $mwocc_plugin_admin, 'mwocc_developer_public_hooks_listing' );

		// Save Product options Setting.
		$this->loader->add_action( 'mwb_occfw_settings_saved_notice', $mwocc_plugin_admin, 'mwocc_product_option_setting' );

	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwocc_woocommerce_one_click_checkout_common_hooks() {

		$mwocc_plugin_common = new One_Click_Checkout_For_Woocommerce_Common( $this->mwocc_get_plugin_name(), $this->mwocc_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwocc_plugin_common, 'mwocc_common_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mwocc_plugin_common, 'mwocc_common_enqueue_scripts' );

		$mwb_occfw_enable_one_click_checkout = get_option( 'mwb_occfw_enable_one_click_checkout' );
		if ( isset( $mwb_occfw_enable_one_click_checkout ) && 'on' === $mwb_occfw_enable_one_click_checkout ) {
			// Redirect to checkpage.
			$this->loader->add_action( 'wp_ajax_mwocc_product_added_cart_redirect_checkout', $mwocc_plugin_common, 'mwocc_product_added_cart_redirect_checkout' );
			$this->loader->add_action( 'wp_ajax_nopriv_mwocc_product_added_cart_redirect_checkout', $mwocc_plugin_common, 'mwocc_product_added_cart_redirect_checkout' );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwocc_woocommerce_one_click_checkout_public_hooks() {

		$mwocc_plugin_public = new One_Click_Checkout_For_Woocommerce_Public( $this->mwocc_get_plugin_name(), $this->mwocc_get_version() );

		$mwb_occfw_enable_one_click_checkout       = get_option( 'mwb_occfw_enable_one_click_checkout' );
		$mwb_occfw_show_chekout_button_shop_page   = get_option( 'mwb_occfw_show_chekout_button_shop_page', '1' );
		$mwb_occfw_show_chekout_button_single_page = get_option( 'mwb_occfw_show_chekout_button_single_page' );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwocc_plugin_public, 'mwocc_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mwocc_plugin_public, 'mwocc_public_enqueue_scripts' );

		if ( isset( $mwb_occfw_enable_one_click_checkout ) && 'on' === $mwb_occfw_enable_one_click_checkout ) {

			if ( isset( $mwb_occfw_show_chekout_button_shop_page ) && '1' === $mwb_occfw_show_chekout_button_shop_page ) {

				$this->loader->add_action( 'woocommerce_after_shop_loop_item', $mwocc_plugin_public, 'mwocc_add_one_click_checkout_button_on_shop_page' );
			}

			if ( isset( $mwb_occfw_show_chekout_button_single_page ) && '1' === $mwb_occfw_show_chekout_button_single_page ) {

				$this->loader->add_action( 'woocommerce_after_add_to_cart_button', $mwocc_plugin_public, 'mwocc_one_click_checkout_button_for_single_page' );
				$this->loader->add_action( 'woocommerce_before_single_product_summary', $mwocc_plugin_public, 'mwocc_one_click_checkout_error_message' );
			}

			$this->loader->add_action( 'woocommerce_thankyou', $mwocc_plugin_public, 'mwocc_guest_details', 10 );
			$this->loader->add_filter( 'woocommerce_checkout_fields', $mwocc_plugin_public, 'mwocc_autofill_checkoutpage_for_guest_user' );
		}
	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwocc_woocommerce_one_click_checkout_api_hooks() {

		$mwocc_plugin_api = new One_Click_Checkout_For_Woocommerce_Rest_Api( $this->mwocc_get_plugin_name(), $this->mwocc_get_version() );

		$this->loader->add_action( 'rest_api_init', $mwocc_plugin_api, 'mwocc_add_endpoint' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function mwocc_run() {
		$this->loader->mwocc_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function mwocc_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return One_Click_Checkout_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function mwocc_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return One_Click_Checkout_For_Woocommerce_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function mwocc_get_onboard() {
		return $this->mwocc_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function mwocc_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_occfw_plug tabs.
	 *
	 * @return Array       An key=>value pair of One Click Checkout For WooCommerce tabs.
	 */
	public function mwocc_plug_default_tabs() {
		$occfw_default_tabs = array();

		$occfw_default_tabs['one-click-checkout-for-woocommerce-general']        = array(
			'title'     => esc_html__( 'General Setting', 'one-click-checkout-for-woocommerce' ),
			'name'      => 'one-click-checkout-for-woocommerce-general',
			'file_path' => ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/one-click-checkout-for-woocommerce-general.php',
		);
		$occfw_default_tabs['one-click-checkout-for-woocommerce-product-option'] = array(
			'title'     => esc_html__( 'Product Options', 'one-click-checkout-for-woocommerce' ),
			'name'      => 'one-click-checkout-for-woocommerce-product-option',
			'file_path' => ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/one-click-checkout-for-woocommerce-product-option.php',
		);
		$occfw_default_tabs['one-click-checkout-for-woocommerce-system-status']  = array(
			'title'     => esc_html__( 'System Status', 'one-click-checkout-for-woocommerce' ),
			'name'      => 'one-click-checkout-for-woocommerce-system-status',
			'file_path' => ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/one-click-checkout-for-woocommerce-system-status.php',
		);
		$occfw_default_tabs['one-click-checkout-for-woocommerce-developer']      = array(
			'title'     => esc_html__( 'Developer', 'one-click-checkout-for-woocommerce' ),
			'name'      => 'one-click-checkout-for-woocommerce-developer',
			'file_path' => ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/one-click-checkout-for-woocommerce-developer.php',
		);

		$occfw_default_tabs =
		// desc - filter for trial.
		apply_filters( 'mwb_occfw_occfw_plugin_standard_admin_settings_tabs', $occfw_default_tabs );

		return $occfw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since 1.0.0
	 * @param string $path   path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwocc_plug_load_template( $path, $params = array() ) {

		// $mwocc_file_path = ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH . $path;

		if ( file_exists( $path ) ) {

			include $path;
		} else {

			/* translators: %s: file path */
			$mwocc_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'one-click-checkout-for-woocommerce' ), $path );
			$this->mwocc_plug_admin_notice( $mwocc_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param string $mwocc_message Message to display.
	 * @param string $type        notice type, accepted values - error/update/update-nag.
	 * @since 1.0.0
	 */
	public static function mwocc_plug_admin_notice( $mwocc_message, $type = 'error' ) {

		$mwocc_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$mwocc_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$mwocc_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$mwocc_classes .= 'notice-success is-dismissible';
				break;

			default:
				$mwocc_classes .= 'notice-error is-dismissible';
		}

		$mwocc_notice  = '<div class="' . esc_attr( $mwocc_classes ) . '">';
		$mwocc_notice .= '<p>' . esc_html( $mwocc_message ) . '</p>';
		$mwocc_notice .= '</div>';

		echo wp_kses_post( $mwocc_notice );
	}


	/**
	 * Show WordPress and server info.
	 *
	 * @return Array $mwocc_system_data       returns array of all WordPress and server related information.
	 * @since  1.0.0
	 */
	public function mwocc_plug_system_status() {
		global $wpdb;
		$mwocc_system_status    = array();
		$mwocc_wordpress_status = array();
		$mwocc_system_data      = array();

		// Get the web server.
		$mwocc_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$mwocc_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get the server's IP address.
		$mwocc_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$mwocc_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$mwocc_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'one-click-checkout-for-woocommerce' );

		// Get the server path.
		$mwocc_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'one-click-checkout-for-woocommerce' );

		// Get the OS.
		$mwocc_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get WordPress version.
		$mwocc_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get and count active WordPress plugins.
		$mwocc_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'one-click-checkout-for-woocommerce' );

		// See if this site is multisite or not.
		$mwocc_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'one-click-checkout-for-woocommerce' ) : __( 'No', 'one-click-checkout-for-woocommerce' );

		// See if WP Debug is enabled.
		$mwocc_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'one-click-checkout-for-woocommerce' ) : __( 'No', 'one-click-checkout-for-woocommerce' );

		// See if WP Cache is enabled.
		$mwocc_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'one-click-checkout-for-woocommerce' ) : __( 'No', 'one-click-checkout-for-woocommerce' );

		// Get the total number of WordPress users on the site.
		$mwocc_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get the number of published WordPress posts.
		$mwocc_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'one-click-checkout-for-woocommerce' );

		// Get PHP memory limit.
		$mwocc_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get the PHP error log path.
		$mwocc_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'one-click-checkout-for-woocommerce' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$mwocc_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get PHP max post size.
		$mwocc_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$mwocc_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$mwocc_system_status['php_architecture'] = '64-bit';
		} else {
			$mwocc_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$mwocc_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Show the number of processes currently running on the server.
		$mwocc_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'one-click-checkout-for-woocommerce' );

		// Get the memory usage.
		$mwocc_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$mwocc_system_status['is_windows']        = true;
			$mwocc_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'one-click-checkout-for-woocommerce' );
		}

		// Get the memory limit.
		$mwocc_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'one-click-checkout-for-woocommerce' );

		// Get the PHP maximum execution time.
		$mwocc_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'one-click-checkout-for-woocommerce' );

		$mwocc_system_status['outgoing_ip'] = function_exists( 'mwocc_file_get_content' ) ? mwocc_file_get_content( 'http://ipecho.net/plain' ) : __( 'N/A (mwocc_file_get_content function does not exist)', 'one-click-checkout-for-woocommerce' );

		$mwocc_system_data['php'] = $mwocc_system_status;
		$mwocc_system_data['wp']  = $mwocc_wordpress_status;
		return $mwocc_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param string $mwocc_components html to display.
	 * @since 1.0.0
	 */
	public function mwocc_plug_generate_html( $mwocc_components = array() ) {
		if ( is_array( $mwocc_components ) && ! empty( $mwocc_components ) ) {
			foreach ( $mwocc_components as $mwocc_component ) {
				if ( ! empty( $mwocc_component['type'] ) && ! empty( $mwocc_component['id'] ) ) {
					switch ( $mwocc_component['type'] ) {

						case 'hidden':
						case 'number':
						case 'email':
						case 'text':
							?>
						<div class="mwb-form-group mwb-occfw-<?php echo esc_attr( $mwocc_component['type'] ); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
							<?php if ( 'number' != $mwocc_component['type'] ) { ?>
												<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?></span>
						<?php } ?>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input
									class="mdc-text-field__input <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>" 
									name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwocc_component['id'] ); ?>"
									type="<?php echo esc_attr( $mwocc_component['type'] ); ?>"
									value="<?php echo ( isset( $mwocc_component['value'] ) ? esc_attr( $mwocc_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?>"
									>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'password':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input 
									class="mdc-text-field__input <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?> mwb-form__password" 
									name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwocc_component['id'] ); ?>"
									type="<?php echo esc_attr( $mwocc_component['type'] ); ?>"
									value="<?php echo ( isset( $mwocc_component['value'] ) ? esc_attr( $mwocc_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?>"
									>
									<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'textarea':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $mwocc_component['id'] ); ?>"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"      for="text-field-hero-input">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<span class="mdc-floating-label"><?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?></span>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<span class="mdc-text-field__resizer">
										<textarea class="mdc-text-field__input <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwocc_component['id'] ); ?>" placeholder="<?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?>"><?php echo ( isset( $mwocc_component['value'] ) ? esc_textarea( $mwocc_component['value'] ) : '' ); // phpcs:ignore. ?></textarea>
									</span>
								</label>
							</div>
						</div>
							<?php
							break;

						case 'select':
						case 'multiselect':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $mwocc_component['id'] ); ?>"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div class="mwb-form-select">
									<select id="<?php echo esc_attr( $mwocc_component['id'] ); ?>" name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?><?php echo ( 'multiselect' === $mwocc_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mdl-textfield__input <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $mwocc_component['type'] ? 'multiple="multiple"' : ''; ?> >
							<?php
							foreach ( $mwocc_component['options'] as $mwocc_key => $mwocc_val ) {
								?>
								<option value="<?php echo esc_attr( $mwocc_key ); ?>"
									<?php
									if ( is_array( $mwocc_component['value'] ) ) {
										selected( in_array( (string) $mwocc_key, $mwocc_component['value'], true ), true );
									} else {
												selected( $mwocc_component['value'], (string) $mwocc_key );
									}
									?>
									>
									<?php echo esc_html( $mwocc_val ); ?>
								</option>
								<?php
							}
							?>
								</select>
									<label class="mdl-textfield__label" for="<?php echo esc_attr( $mwocc_component['id'] ); ?>"><?php echo esc_html( $mwocc_component['description'] ); ?><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>
							<?php
							break;
						case 'checkbox':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mdc-form-field">
									<div class="mdc-checkbox">
										<input 
										name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwocc_component['id'] ); ?>"
										type="checkbox"
										class="mdc-checkbox__native-control <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>"
										value="1" <?php checked( $mwocc_component['value'], '1' ); ?>
										/>
										<div class="mdc-checkbox__background">
											<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
												<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
											</svg>
											<div class="mdc-checkbox__mixedmark"></div>
										</div>
										<div class="mdc-checkbox__ripple"></div>
									</div>
									<div class="mwb_woo_custom_checkbox_message_for_one_click_checkout" aria-hidden="true">
										<?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?>
									</div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mwb-flex-col">
							<?php
							foreach ( $mwocc_component['options'] as $mwocc_radio_key => $mwocc_radio_val ) {
								?>
								<div class="mdc-form-field">
									<div class="mdc-radio">
									<input
									name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
									value="<?php echo esc_attr( $mwocc_radio_key ); ?>"
									type="radio"
									class="mdc-radio__native-control <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>"
									<?php checked( $mwocc_radio_key, $mwocc_component['value'] ); ?>
										>
										<div class="mdc-radio__background">
											<div class="mdc-radio__outer-circle"></div>
											<div class="mdc-radio__inner-circle"></div>
										</div>
										<div class="mdc-radio__ripple"></div>
									</div>
									<label for="radio-1"><?php echo esc_html( $mwocc_radio_val ); ?></label>
									</div>    
								<?php
							}
							?>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio-switch':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>" type="checkbox" id="<?php echo esc_html( $mwocc_component['id'] ); ?>" value="on" class="mdc-switch__native-control <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>" role="switch" aria-checked="
							<?php
							if ( 'on' == $mwocc_component['value'] ) {
								echo 'true';
							} else {
								echo 'false';
							}
							?>
							" <?php checked( $mwocc_component['value'], 'on' ); ?> >
							</div>
							</div>
								</div>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'button':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label"></div>
							<div class="mwb-form-group__control">
								<button class="mdc-button mdc-button--raised" name= "<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwocc_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
									<span class="mdc-button__label <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>"><?php echo ( isset( $mwocc_component['button_text'] ) ? esc_html( $mwocc_component['button_text'] ) : '' ); ?></span>
								</button>
							</div>
						</div>

							<?php
							break;

						case 'multi':
							?>
							<div class="mwb-form-group mwb-occfw-<?php echo esc_attr( $mwocc_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
									</div>
									<div class="mwb-form-group__control">
							<?php
							foreach ( $mwocc_component['value'] as $component ) {
								?>
											<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
								<?php if ( 'number' != $component['type'] ) { ?>
															<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?></span>
							<?php } ?>
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<input 
								class="mdc-text-field__input <?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>" 
								name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
								id="<?php echo esc_attr( $component['id'] ); ?>"
								type="<?php echo esc_attr( $component['type'] ); ?>"
								value="<?php echo ( isset( $mwocc_component['value'] ) ? esc_attr( $mwocc_component['value'] ) : '' ); ?>"
								placeholder="<?php echo ( isset( $mwocc_component['placeholder'] ) ? esc_attr( $mwocc_component['placeholder'] ) : '' ); ?>"
								<?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>
												>
								</label>
							<?php } ?>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
								<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
							<div class="mwb-form-group mwb-occfw-<?php echo esc_attr( $mwocc_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label>
										<input 
										class="<?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>" 
										name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwocc_component['id'] ); ?>"
										type="<?php echo esc_attr( $mwocc_component['type'] ); ?>"
										value="<?php echo ( isset( $mwocc_component['value'] ) ? esc_attr( $mwocc_component['value'] ) : '' ); ?>"
									<?php echo esc_html( ( 'date' === $mwocc_component['type'] ) ? 'max=' . gmdate( 'Y-m-d', strtotime( gmdate( 'Y-m-d', mktime() ) . ' + 365 day' ) ) . 'min=' . gmdate( 'Y-m-d' ) . '' : '' ); ?>
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'select_and_text':
							?>
							<div class="mwb-form-group mwb-occfw-text">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $mwocc_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwocc_component['title'] ) ? esc_html( $mwocc_component['title'] ) : '' ); // phpcs:ignore. ?></label>
								</div>
								<div class="mwb-form-group__control">
								<?php
								foreach ( $mwocc_component['value'] as $component ) {
									?>
										<?php if ( 'select' !== $component['type'] ) { ?>
										<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
													<span class="mdc-floating-label" id="my-label-id" style="">
														<?php echo ( isset( $component['placeholder'] ) ? esc_attr( $component['placeholder'] ) : '' ); ?></span>
													</span>
													<span class="mdc-notched-outline__trailing"></span>
												</span>
											<?php } ?>
											<?php if ( 'text' === $component['type'] ) { ?>
												<input 
												class="mdc-text-field__input <?php echo ( isset( $component['class'] ) ? esc_attr( $component['class'] ) : '' ); ?>" 
												name="<?php echo ( isset( $component['name'] ) ? esc_html( $component['name'] ) : esc_html( $component['id'] ) ); ?>"
												id="<?php echo esc_attr( $component['id'] ); ?>"
												type="<?php echo esc_attr( $component['type'] ); ?>"
												value="<?php echo ( isset( $component['value'] ) ? esc_attr( $component['value'] ) : '' ); ?>"
												placeholder="<?php echo ( isset( $component['placeholder'] ) ? esc_attr( $component['placeholder'] ) : '' ); ?>"
												<?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>
												>
											<?php } elseif ( 'select' === $component['type'] ) { ?>
												<select id="<?php echo esc_attr( $component['id'] ); ?>" name="<?php echo ( isset( $component['name'] ) ? esc_html( $component['name'] ) : esc_html( $component['id'] ) ); ?><?php echo ( 'multiselect' === $component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $component['id'] ); ?>" class="mdl-textfield__input <?php echo ( isset( $component['class'] ) ? esc_attr( $component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $component['type'] ? 'multiple="multiple"' : ''; ?> >
													<?php
													foreach ( $component['options'] as $mwocc_key => $mwocc_val ) {
														?>
														<option value="<?php echo esc_attr( $mwocc_key ); ?>"
															<?php
															if ( is_array( $component['value'] ) ) {
																selected( in_array( (string) $mwocc_key, $component['value'], true ), true );
															} else {
																selected( $component['value'], (string) $mwocc_key );
															}
															?>
															>
															<?php echo esc_html( $mwocc_val ); ?>
														</option>
														<?php
													}
													?>
													</select>
											<?php } ?>
											<?php if ( 'select' !== $component['type'] ) { ?>
											</label>
										<?php } ?>
									<?php } ?>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwocc_component['description'] ) ? esc_attr( $mwocc_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'submit':
							?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo ( isset( $mwocc_component['name'] ) ? esc_html( $mwocc_component['name'] ) : esc_html( $mwocc_component['id'] ) ); ?>"
								id="<?php echo esc_attr( $mwocc_component['id'] ); ?>"
								class="<?php echo ( isset( $mwocc_component['class'] ) ? esc_attr( $mwocc_component['class'] ) : '' ); ?>"
								value="<?php echo esc_attr( $mwocc_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
							<?php
							break;

						default:
							break;
					}
				}
			}
		}
	}

	/**
	 * Function for fetching all products and all categories in current woocommerce shop.
	 *
	 * @param [string] $param Contain selected values.
	 * @return string
	 */
	public function mwocc_woocommerce_get_all_products( $param ) {

		if ( 'products' === $param ) {

			$args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'DESC',
			);

			$mwb_wocc_all_products = get_posts( $args );
			return $mwb_wocc_all_products;

		} elseif ( 'categories' === $param ) {

			$taxonomy     = 'product_cat';
			$orderby      = 'term_id';
			$show_count   = 0;
			$pad_counts   = 0;
			$hierarchical = 1;
			$title        = '';
			$empty        = 0;

			$mwb_wocc_args           = array(
				'taxonomy'     => $taxonomy,
				'orderby'      => $orderby,
				'show_count'   => $show_count,
				'pad_counts'   => $pad_counts,
				'hierarchical' => $hierarchical,
				'title_li'     => $title,
				'hide_empty'   => $empty,
			);
			$mwb_wocc_all_categories = get_categories( $mwb_wocc_args );
			return $mwb_wocc_all_categories;
		} else {
			return '';
		}
	}

	/**
	 * Function for fetching all products array with product type and product names.
	 *
	 * @param [string] $product_type contain product type.
	 * @param [string] $product contain object.
	 * @return string
	 */
	public function mwocc_fetch_product_array( $product_type, $product ) {

		if ( 'simple' === $product_type || 'external' === $product_type || 'variable' === $product_type || 'grouped' === $product_type ) {

			$product_get_data = $product->get_data();

			$mwb_woo_one_click_checkout_product = array(
				'product_type' => $product_type,
				'product_name' => $product_get_data['name'],
			);

			return $mwb_woo_one_click_checkout_product;
		} else {
			return '';
		}
	}

}
