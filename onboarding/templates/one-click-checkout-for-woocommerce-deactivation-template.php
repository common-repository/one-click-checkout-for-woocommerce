<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Makewebbetter_Onboarding
 * @subpackage Makewebbetter_Onboarding/admin/onboarding
 */

global $pagenow, $mwocc_mwb_occfw_obj;
if ( empty( $pagenow ) || 'plugins.php' != $pagenow ) {
	return false;
}
$mwb_plugin_name                  = ! empty( explode( '/', plugin_basename( __FILE__ ) ) ) ? explode( '/', plugin_basename( __FILE__ ) )[0] : '';
$mwb_plugin_deactivation_id       = $mwb_plugin_name . '-no_thanks_deactive';
$mwb_plugin_onboarding_popup_id   = $mwb_plugin_name . '-onboarding_popup';
$mwocc_onboarding_form_deactivate =
// desc - filter for trial.
apply_filters( 'mwb_occfw_deactivation_form_fields', array() );

?>
<?php if ( ! empty( $mwocc_onboarding_form_deactivate ) ) : ?>
	<div id="<?php echo esc_attr( $mwb_plugin_onboarding_popup_id ); ?>" class="mdc-dialog mdc-dialog--scrollable 
		<?php
		echo // desc - filter for trial.
		esc_attr( apply_filters( 'mwb_stand_dialog_classes', 'one-click-checkout-for-woocommerce' ) );
		?>
	">
		<div class="mwb-occfw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-occfw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-occfw-on-boarding-close-btn">
						<a href="#">
							<span class="mwocc-close-form material-icons mwb-occfw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span>
						</a>
					</div>

					<h3 class="mwb-occfw-on-boarding-heading mdc-dialog__title"></h3>
					<p class="mwb-occfw-on-boarding-desc"><?php esc_html_e( 'May we have a little info about why you are deactivating?', 'one-click-checkout-for-woocommerce' ); ?></p>
					<form action="#" method="post" class="mwb-occfw-on-boarding-form">
						<?php
						$mwocc_onboarding_deactive_html = $mwocc_mwb_occfw_obj->mwocc_plug_generate_html( $mwocc_onboarding_form_deactivate );
						echo esc_html( $mwocc_onboarding_deactive_html );
						?>
						<div class="mwb-occfw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-occfw-on-boarding-form-submit mwb-occfw-on-boarding-form-verify ">
								<input type="submit" class="mwb-occfw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-occfw-on-boarding-form-no_thanks">
								<a href="#" id="<?php echo esc_attr( $mwb_plugin_deactivation_id ); ?>" class="
									<?php
									echo // desc - filter for trial.
									esc_attr( apply_filters( 'mwb_stand_no_thank_classes', 'one-click-checkout-for-woocommerce-no_thanks' ) );
									?>
								 mdc-button"><?php esc_html_e( 'Skip and Deactivate Now', 'one-click-checkout-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
