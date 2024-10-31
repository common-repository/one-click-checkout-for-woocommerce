<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    One_Click_Checkout_For_Woocommerce
 * @subpackage One_Click_Checkout_For_Woocommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'One_Click_Checkout_For_Woocommerce_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Hydroshop_Api_Management
	 * @subpackage Hydroshop_Api_Management/includes
	 * @author     MakeWebBetter <makewebbetter.com>
	 */
	class One_Click_Checkout_For_Woocommerce_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   Array $mwocc_request  data of requesting headers and other information.
		 * @return  Array $mwb_occfw_rest_response    returns processed data and status of operations.
		 */
		public function mwocc_default_process( $mwocc_request ) {
			$mwb_occfw_rest_response = array();

			// Write your custom code here.

			$mwb_occfw_rest_response['status'] = 200;
			$mwb_occfw_rest_response['data']   = $mwocc_request->get_headers();
			return $mwb_occfw_rest_response;
		}
	}
}
