<?php
/**
 * Guest Order Tracking for WooCommerce - Admin General issues
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_GOTWC_Admin_General' ) ) {

	class Alg_GOTWC_Admin_General {
		/**
		 * Sets action links
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function action_links( $links ) {
			$admin_tab = Alg_GOTWC_Core::get_admin_tab();
			$custom_links = array( '<a href="' . admin_url( 'admin.php?page=wc-settings&tab='.$admin_tab->admin_tab_id.'' ) . '">' . __( 'Settings', 'guest-order-tracking-for-woocommerce' ) . '</a>' );
			return array_merge( $custom_links, $links );
		}
	}
}