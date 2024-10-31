<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://makewebbetter.com/
 * @since   1.0.0
 * @package One_Click_Checkout_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       One Click Checkout For WooCommerce
 * Plugin URI:        https://makewebbetter.com/product/one-click-checkout-for-woocommerce/
 * Description:       This plugin will help merchant to enable one click checkout for their customers, hence increase in Sales.
 * Version:           1.0.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       one-click-checkout-for-woocommerce
 * Domain Path:       /languages
 *
 * WC Requires at least: 4.6
 * WC tested up to:      5.8.o
 * WP Requires at least: 5.1.0
 * WP tested up to:      5.8.1
 * Requires PHP:         7.2 or Higher
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Active Detection.
 *
 * @since    1.0.0
 * @param    string $plugin_slug index file of plugin.
 */
function mwocc_is_plugin_active( $plugin_slug = '' ) {

	if ( empty( $plugin_slug ) ) {

		return false;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

	}

	return in_array( $plugin_slug, $active_plugins ) || array_key_exists( $plugin_slug, $active_plugins );

}

/**
 * The code that runs during plugin validation.
 * This action is checks for WooCommerce Dependency.
 *
 * @since    1.0.0
 */
function mwocc_plugin_activation() {

	$activation['status']  = true;
	$activation['message'] = '';

	// Dependant plugin.
	if ( ! mwocc_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status']  = false;
		$activation['message'] = 'woo_inactive';

	}

	return $activation;
}

$mwocc_plugin_activation = mwocc_plugin_activation();

if ( true === $mwocc_plugin_activation['status'] ) {

	/**
	 * Define plugin constants.
	 *
	 * @since 1.0.0
	 */
	function mwocc_define_one_click_checkout_for_woocommerce_constants() {

		mwocc_woocommerce_one_click_checkout_constants( 'ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
		mwocc_woocommerce_one_click_checkout_constants( 'ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
		mwocc_woocommerce_one_click_checkout_constants( 'ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
		mwocc_woocommerce_one_click_checkout_constants( 'ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
		mwocc_woocommerce_one_click_checkout_constants( 'ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'One Click Checkout For WooCommerce' );
	}

	/**
	 * If the site is multisite and a plugin has been activated on the network and a site is created.
	 * Then the activation hook will not work. You can executes the activation code using this function.
	 *
	 * @param [type] $new_site contain blog object.
	 * @return void
	 */
	function mwocc_standard_plugin_on_create_blog( $new_site ) {

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		if ( is_plugin_active_for_network( 'one-click-checkout-for-woocommerce/one-click-checkout-for-woocommerce.php' ) ) {

			$blog_id = $new_site->blog_id;
			switch_to_blog( $blog_id );

			require_once plugin_dir_path( __FILE__ ) . 'includes/class-one-click-checkout-for-woocommerce-activator.php';
			restore_current_blog();
		}

	}
	add_action( 'wp_initialize_site', 'mwocc_standard_plugin_on_create_blog', 900 );

	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param String $key   Key for contant.
	 * @param String $value value for contant.
	 * @since 1.0.0
	 */
	function mwocc_woocommerce_one_click_checkout_constants( $key, $value ) {

		if ( ! defined( $key ) ) {

			define( $key, $value );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-one-click-checkout-for-woocommerce-activator.
	 *
	 * @param [type] $network_wide contain blog object.
	 * @return void
	 */
	function mwocc_activate_one_click_checkout_for_woocommerce( $network_wide ) {

		include_once plugin_dir_path( __FILE__ ) . 'includes/class-one-click-checkout-for-woocommerce-activator.php';
		One_Click_Checkout_For_Woocommerce_Activator::mwocc_woocommerce_one_click_checkout_activate( $network_wide );
		$mwb_occfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_occfw_active_plugin ) && ! empty( $mwb_occfw_active_plugin ) ) {
			$mwb_occfw_active_plugin['one-click-checkout-for-woocommerce'] = array(
				'plugin_name' => __( 'One Click Checkout For WooCommerce', 'one-click-checkout-for-woocommerce' ),
				'active' => '1',
			);
		} else {
			$mwb_occfw_active_plugin                        = array();
			$mwb_occfw_active_plugin['one-click-checkout-for-woocommerce'] = array(
				'plugin_name' => __( 'One Click Checkout For WooCommerce', 'one-click-checkout-for-woocommerce' ),
				'active' => '1',
			);
		}
		update_option( 'mwb_all_plugins_active', $mwb_occfw_active_plugin );
	}

	/**
	 * This function is used to get user ip address.
	 *
	 * @param [string] $url url.
	 * @return string
	 */
	function mwocc_file_get_content( $url ) {
		$response = wp_remote_get( $url );
		$response = wp_remote_retrieve_body( $response );
		return $response;
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-one-click-checkout-for-woocommerce-deactivator.php
	 */
	function mwocc_deactivate_one_click_checkout_for_woocommerce() {
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-one-click-checkout-for-woocommerce-deactivator.php';
		One_Click_Checkout_For_Woocommerce_Deactivator::mwocc_woocommerce_one_click_checkout_deactivate();
		$mwb_occfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_occfw_deactive_plugin ) && ! empty( $mwb_occfw_deactive_plugin ) ) {
			foreach ( $mwb_occfw_deactive_plugin as $mwb_occfw_deactive_key => $mwb_occfw_deactive ) {
				if ( 'one-click-checkout-for-woocommerce' === $mwb_occfw_deactive_key ) {
					$mwb_occfw_deactive_plugin[ $mwb_occfw_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'mwb_all_plugins_active', $mwb_occfw_deactive_plugin );
	}

	register_activation_hook( __FILE__, 'mwocc_activate_one_click_checkout_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'mwocc_deactivate_one_click_checkout_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-one-click-checkout-for-woocommerce.php';


	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since 1.0.0
	 */
	function mwocc_run_one_click_checkout_for_woocommerce() {
		mwocc_define_one_click_checkout_for_woocommerce_constants();
		$mwocc_occfw_plugin_standard = new One_Click_Checkout_For_Woocommerce();
		$mwocc_occfw_plugin_standard->mwocc_run();
		$GLOBALS['mwocc_mwb_occfw_obj'] = $mwocc_occfw_plugin_standard;

	}
	mwocc_run_one_click_checkout_for_woocommerce();


	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwocc_woocommerce_one_click_checkout_settings_link' );

	/**
	 * Settings link.
	 *
	 * @since 1.0.0
	 * @param Array $links Settings link array.
	 */
	function mwocc_woocommerce_one_click_checkout_settings_link( $links ) {

		$my_link = array(
			'<a href="' . admin_url( 'admin.php?page=one_click_checkout_for_woocommerce_menu' ) . '">' . __( 'Settings', 'one-click-checkout-for-woocommerce' ) . '</a>',
		);
		return array_merge( $my_link, $links );
	}

	/**
	 * Adding custom setting links at the plugin activation list.
	 *
	 * @param  array  $links_array      array containing the links to plugin.
	 * @param  string $plugin_file_name plugin file name.
	 * @return array
	 */
	function mwocc_woocommerce_one_click_checkout_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$links_array[] = '<a href="#" target="_blank"><img src="' . esc_html( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">' . __( 'Demo', 'one-click-checkout-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="#" target="_blank"><img src="' . esc_html( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">' . __( 'Documentation', 'one-click-checkout-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="#" target="_blank"><img src="' . esc_html( ONE_CLICK_CHECKOUT_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">' . __( 'Support', 'one-click-checkout-for-woocommerce' ) . '</a>';
		}
		return $links_array;
	}
	add_filter( 'plugin_row_meta', 'mwocc_woocommerce_one_click_checkout_custom_settings_at_plugin_tab', 10, 2 );

} else {

	add_action( 'admin_init', 'mwocc_plugin_activation_failure' );

	/**
	 * Deactivate this plugin.
	 *
	 * @since    1.0.0
	 */
	function mwocc_plugin_activation_failure() {

		// To hide Plugin activated notice.
		if ( ! empty( $_GET['activate'] ) ) {

			unset( $_GET['activate'] );
		}

		deactivate_plugins( plugin_basename( __FILE__ ) );
		mwocc_activation_admin_notice();
	}

	/**
	 * This function is used to display plugin activation error notice.
	 *
	 * @since    1.0.0
	 */
	function mwocc_activation_admin_notice() {

		global $mwocc_plugin_activation;

		?>

		<?php if ( 'woo_inactive' == $mwocc_plugin_activation['message'] ) : ?>

			<div class="notice notice-error is-dismissible mwb-notice">
				<p><strong><?php esc_html_e( 'WooCommerce', 'one-click-checkout-for-woocommerce' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'one-click-checkout-for-woocommerce' ); ?><strong><?php esc_html_e( 'One Click Checkout For WooCommerce', 'one-click-checkout-for-woocommerce' ); ?></strong><?php esc_html_e( '.', 'one-click-checkout-for-woocommerce' ); ?></p>
			</div>

			<?php
		endif;
	}
}
