<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to list all the hooks and filter with their descriptions.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $mwocc_mwb_occfw_obj;
$mwocc_developer_admin_hooks =
// desc - filter for trial.
apply_filters( 'mwocc_developer_admin_hooks_array', array() );
$count_admin                  = mwocc_filtered_array( $mwocc_developer_admin_hooks );
$mwocc_developer_public_hooks =
// desc - filter for trial.
apply_filters( 'mwocc_developer_public_hooks_array', array() );
$count_public = mwocc_filtered_array( $mwocc_developer_public_hooks );
?>
<!--  template file for admin settings. -->
<div class="mwocc-section-wrap">
	<div class="mwb-col-wrap">
		<div id="admin-hooks-listing" class="table-responsive mdc-data-table">
			<table class="mwb-occfw-table mdc-data-table__table mwb-table"  id="mwb-occfw-wp">
				<thead>
				<tr><th class="mdc-data-table__header-cell"><?php esc_html_e( 'Admin Hooks', 'one-click-checkout-for-woocommerce' ); ?></th></tr>
				<tr>
					<th class="mdc-data-table__header-cell"><?php esc_html_e( 'Type of Hook', 'one-click-checkout-for-woocommerce' ); ?></th>
					<th class="mdc-data-table__header-cell"><?php esc_html_e( 'Hooks', 'one-click-checkout-for-woocommerce' ); ?></th>
					<th class="mdc-data-table__header-cell"><?php esc_html_e( 'Hooks description', 'one-click-checkout-for-woocommerce' ); ?></th>
				</tr>
				</thead>
				<tbody class="mdc-data-table__content">
				<?php
				if ( ! empty( $count_admin ) ) {
					foreach ( $count_admin as $k => $v ) {
						if ( isset( $v['action_hook'] ) ) {
							?>
						<tr class="mdc-data-table__row"><td class="mdc-data-table__cell"><?php esc_html_e( 'Action Hook', 'one-click-checkout-for-woocommerce' ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['action_hook'] ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['desc'] ); ?></td></tr>
							<?php
						} else {
							?>
							<tr class="mdc-data-table__row"><td class="mdc-data-table__cell"><?php esc_html_e( 'Filter Hook', 'one-click-checkout-for-woocommerce' ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['filter_hook'] ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['desc'] ); ?></td></tr>
							<?php
						}
					}
				} else {
					?>
					<tr class="mdc-data-table__row"><td><?php esc_html_e( 'No Hooks Found', 'one-click-checkout-for-woocommerce' ); ?><td></tr>
					<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="mwb-col-wrap">
		<div id="public-hooks-listing" class="table-responsive mdc-data-table">
			<table class="mwb-occfw-table mdc-data-table__table mwb-table" id="mwb-occfw-sys">
				<thead>
				<tr><th class="mdc-data-table__header-cell"><?php esc_html_e( 'Public Hooks', 'one-click-checkout-for-woocommerce' ); ?></th></tr>
				<tr>
					<th class="mdc-data-table__header-cell"><?php esc_html_e( 'Type of Hook', 'one-click-checkout-for-woocommerce' ); ?></th>
					<th class="mdc-data-table__header-cell"><?php esc_html_e( 'Hooks', 'one-click-checkout-for-woocommerce' ); ?></th>
					<th class="mdc-data-table__header-cell"><?php esc_html_e( 'Hooks description', 'one-click-checkout-for-woocommerce' ); ?></th>
				</tr>
				</thead>
				<tbody class="mdc-data-table__content">
				<?php
				if ( ! empty( $count_public ) ) {
					foreach ( $count_public as $k => $v ) {
						if ( isset( $v['action_hook'] ) ) {
							?>
						<tr class="mdc-data-table__row"><td class="mdc-data-table__cell"><?php esc_html_e( 'Action Hook', 'one-click-checkout-for-woocommerce' ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['action_hook'] ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['desc'] ); ?></td></tr>
							<?php
						} else {
							?>
							<tr class="mdc-data-table__row"><td class="mdc-data-table__cell"><?php esc_html_e( 'Filter Hook', 'one-click-checkout-for-woocommerce' ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['filter_hook'] ); ?></td><td class="mdc-data-table__cell"><?php echo esc_html( $v['desc'] ); ?></td></tr>
							<?php
						}
					}
				} else {
					?>
					<tr class="mdc-data-table__row"><td><?php esc_html_e( 'No Hooks Found', 'one-click-checkout-for-woocommerce' ); ?><td></tr>
					<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
/**
 * Function use for filteration of array.
 *
 * @param [type] $argu of the array.
 * @return array
 */
function mwocc_filtered_array( $argu ) {
	$count_admin = array();
	foreach ( $argu as $key => $value ) {
		foreach ( $value as $k => $originvalue ) {
			if ( isset( $originvalue['action_hook'] ) ) {
				$val                              = str_replace( ' ', '', $originvalue['action_hook'] );
				$val                              = str_replace( "do_action('", '', $val );
				$val                              = str_replace( "');", '', $val );
				$count_admin[ $k ]['action_hook'] = $val;
			}
			if ( isset( $originvalue['filter_hook'] ) ) {
				$val                              = str_replace( ' ', '', $originvalue['filter_hook'] );
				$val                              = str_replace( "apply_filters('", '', $val );
				$val                              = str_replace( "',array());", '', $val );
				$count_admin[ $k ]['filter_hook'] = $val;
			}
			$vale                      = str_replace( '//desc - ', '', $originvalue['desc'] );
			$count_admin[ $k ]['desc'] = $vale;
		}
	}
	return $count_admin;
}
