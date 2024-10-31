<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
global $mwb_woo_one_click_checkout_products;
global $mwb_woo_one_click_checkout_hidden_product;

$mwb_woo_one_click_checkout_product_settings = get_option( 'mwb_woo_one_click_checkout_product_settings', array() );

?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-occfw-gen-section-form">
	<input type="hidden" name="mwb_woo_one_click_checkout_product_option_nonce" value="<?php echo esc_html( wp_create_nonce( 'mwb-woo-one-click-product-nonce' ) ); ?>">
	<div class="mwocc-secion-wrap">
		<?php
		$mwb_woo_one_click_checkout_all_product  = $this->mwocc_woocommerce_get_all_products( 'products' );
		$mwb_woo_one_click_checkout_all_category = $this->mwocc_woocommerce_get_all_products( 'categories' );
		?>
		<table>
			<tr>
				<td>
					<label for="mwb_woo_one_click_checkout_include_hidden_products"><?php esc_html_e( 'Include and Exclude Hidden Product', 'one-click-checkout-for-woocommerce' ); ?></label>
				</td>
				<?php
				if ( ! empty( $mwb_woo_one_click_checkout_all_product ) && is_array( $mwb_woo_one_click_checkout_all_product ) ) {
					foreach ( $mwb_woo_one_click_checkout_all_product as $mwb_hidden_product_key => $mwb_hidden_product_value ) {
						$product = wc_get_product( $mwb_hidden_product_value->ID );
						$mwb_woo_one_click_checkout_hidden_product[ $product->get_id() ] = $this->mwocc_fetch_product_array( $product->get_type(), $product );
					}
				}
				?>
				<td>
					<select name="mwb_woo_one_click_checkout_product_settings[hidden_included_product][]" id="mwb_woo_one_click_checkout_include_hidden_products" multiple>
						<?php
						if ( ! empty( $mwb_woo_one_click_checkout_hidden_product ) && is_array( $mwb_woo_one_click_checkout_hidden_product ) ) {
							foreach ( $mwb_woo_one_click_checkout_hidden_product as $hidden_product_key => $hidden_product_value ) {
								?>
								<option value="<?php echo esc_html( $hidden_product_key ); ?>" 
								<?php
								if ( ! empty( $mwb_woo_one_click_checkout_product_settings['hidden_included_product'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['hidden_included_product'] ) ) {
									foreach ( $mwb_woo_one_click_checkout_product_settings['hidden_included_product'] as $mwb_db_hidden_key => $mwb_db_hidden_value ) {
										if ( $hidden_product_key == $mwb_db_hidden_value ) {
											echo 'selected = selected';
										}
									}
								}
								?>
									><?php echo esc_html( $hidden_product_value['product_name'] ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>
					<label for="mwb_woo_one_click_checkout_include_products"><?php echo esc_html_e( 'Include Products To Show One-Click Checkout Button', 'one-click-checkout-for-woocommerce' ); ?></label>
				</td>
				<?php
				if ( ! empty( $mwb_woo_one_click_checkout_all_product ) && is_array( $mwb_woo_one_click_checkout_all_product ) ) {
					foreach ( $mwb_woo_one_click_checkout_all_product as $mwb_hidden_product_key => $mwb_hidden_product_value ) {
						$product = wc_get_product( $mwb_hidden_product_value->ID );
						$mwb_woo_one_click_checkout_products[ $product->get_id() ] = $this->mwocc_fetch_product_array( $product->get_type(), $product );
					}
				}
				?>
				<td>
					<select name="mwb_woo_one_click_checkout_product_settings[included_product][]" id="mwb_woo_one_click_checkout_include_products" multiple>
						<?php
						if ( ! empty( $mwb_woo_one_click_checkout_products ) && is_array( $mwb_woo_one_click_checkout_products ) ) {
							foreach ( $mwb_woo_one_click_checkout_products as $mwb_woo_product_key => $mwb_woo_product_value ) {
								?>
								<option value="<?php echo esc_html( $mwb_woo_product_key ); ?>" 
								<?php
								if ( ! empty( $mwb_woo_one_click_checkout_product_settings['included_product'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['included_product'] ) ) {
									foreach ( $mwb_woo_one_click_checkout_product_settings['included_product'] as $mwb_db_product_key => $mwb_db_product_value ) {
										if ( $mwb_woo_product_key == $mwb_db_product_value ) {
											echo 'selected = selected';
										}
									}
								}
								?>
								><?php echo esc_html( $mwb_woo_product_value['product_name'] ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>
					<label for="mwb_woo_one_click_checkout_exclude_products"><?php echo esc_html_e( 'Exclude Products For Remove One-Click Checkout Button', 'one-click-checkout-for-woocommerce' ); ?></label>
				</td>
				<?php
				if ( ! empty( $mwb_woo_one_click_checkout_all_product ) && is_array( $mwb_woo_one_click_checkout_all_product ) ) {
					foreach ( $mwb_woo_one_click_checkout_all_product as $mwb_hidden_product_key => $mwb_hidden_product_value ) {
						$product = wc_get_product( $mwb_hidden_product_value->ID );
						$mwb_woo_one_click_checkout_products[ $product->get_id() ] = $this->mwocc_fetch_product_array( $product->get_type(), $product );
					}
				}
				?>
				<td>
					<select name="mwb_woo_one_click_checkout_product_settings[excluded_product][]" id="mwb_woo_one_click_checkout_exclude_products" multiple>
						<?php
						if ( ! empty( $mwb_woo_one_click_checkout_products ) && is_array( $mwb_woo_one_click_checkout_products ) ) {
							foreach ( $mwb_woo_one_click_checkout_products as $mwb_woo_product_keys => $mwb_woo_product_values ) {
								?>
								<option value="<?php echo esc_html( $mwb_woo_product_keys ); ?>"
								<?php
								if ( ! empty( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['excluded_product'] ) ) {
									foreach ( $mwb_woo_one_click_checkout_product_settings['excluded_product'] as $mwb_db_product_keys => $mwb_db_product_values ) {
										if ( $mwb_woo_product_keys == $mwb_db_product_values ) {
											echo 'selected = selected';
										}
									}
								}
								?>
								><?php echo esc_html( $mwb_woo_product_values['product_name'] ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>
					<label for="mwb_woo_one_click_checkout_product_categories"><?php echo esc_html_e( 'Select Categories For Showing One-Click Checkout Button', 'one-click-checkout-for-woocommerce' ); ?></label>
				</td>
				<td>
					<select name="mwb_woo_one_click_checkout_product_settings[categories][]" id="mwb_woo_one_click_checkout_product_categories" multiple>
						<?php
						if ( ! empty( $mwb_woo_one_click_checkout_all_category ) && is_array( $mwb_woo_one_click_checkout_all_category ) ) {
							foreach ( $mwb_woo_one_click_checkout_all_category as $mwb_woo_category_key => $mwb_woo_category_value ) {
								?>
								<option value="<?php echo esc_html( $mwb_woo_category_value->term_id ); ?>"
								<?php
								if ( ! empty( $mwb_woo_one_click_checkout_product_settings['categories'] ) && is_array( $mwb_woo_one_click_checkout_product_settings['categories'] ) ) {
									foreach ( $mwb_woo_one_click_checkout_product_settings['categories'] as $mwb_db_category_key => $mwb_db_category_value ) {
										if ( $mwb_woo_category_value->term_id == $mwb_db_category_value ) {
											echo ' selected = selected ';
										}
									}
								}
								?>
								><?php echo esc_html( $mwb_woo_category_value->name ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
		</table>
		<input type="submit" name="mwb_woo_one_click_checkout_product_option_setting_submit" id="mwb_woo_one_click_checkout_product_option_setting" value="<?php esc_html_e( 'Save Changes', 'one-click-checkout-for-woocommerce' ); ?>">
	</div>
</form>
