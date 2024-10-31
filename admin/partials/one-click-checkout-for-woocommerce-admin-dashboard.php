<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $mwocc_mwb_occfw_obj;
$mwocc_active_tab   = isset( $_GET['mwocc_tab'] ) ? sanitize_key( $_GET['mwocc_tab'] ) : 'one-click-checkout-for-woocommerce-general';
$occfw_default_tabs = $mwocc_mwb_occfw_obj->mwocc_plug_default_tabs();
?>
<header>
	<?php
		// desc - This hook is used for trial.
		do_action( 'mwb_occfw_settings_saved_notice' );
	?>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', $mwocc_mwb_occfw_obj->mwocc_get_plugin_name() ) ) ); ?></h1>
		<a href="https://docs.makewebbetter.com/" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'one-click-checkout-for-woocommerce' ); ?></a>
		<span>|</span>
		<a href="https://makewebbetter.com/contact-us/" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'one-click-checkout-for-woocommerce' ); ?></a>
	</div>
</header>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $occfw_default_tabs ) && ! empty( $occfw_default_tabs ) ) {
				foreach ( $occfw_default_tabs as $mwocc_tab_key => $occfw_default_tabs ) {
					$mwocc_tab_classes = 'mwb-link ';
					if ( ! empty( $mwocc_active_tab ) && $mwocc_active_tab === $mwocc_tab_key ) {
						$mwocc_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $mwocc_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=one_click_checkout_for_woocommerce_menu' ) . '&mwocc_tab=' . esc_attr( $mwocc_tab_key ) ); ?>" class="<?php echo esc_attr( $mwocc_tab_classes ); ?>"><?php echo esc_html( $occfw_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>
	<section class="mwb-section">
		<div>
			<?php
				// desc - This hook is used for trial.
				do_action( 'mwb_occfw_before_general_settings_form' );
				// if submenu is directly clicked on woocommerce.
			if ( empty( $mwocc_active_tab ) ) {
				$mwocc_active_tab = 'mwb_occfw_plug_general';
			}

				// look for the path based on the tab id in the admin templates.
				$occfw_default_tabs     = $mwocc_mwb_occfw_obj->mwocc_plug_default_tabs();
				$mwocc_tab_content_path = $occfw_default_tabs[ $mwocc_active_tab ]['file_path'];
				$mwocc_mwb_occfw_obj->mwocc_plug_load_template( $mwocc_tab_content_path );
				// desc - This hook is used for trial.
				do_action( 'mwb_occfw_after_general_settings_form' );
			?>
		</div>
	</section>
