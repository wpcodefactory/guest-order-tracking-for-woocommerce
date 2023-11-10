<?php
/**
 * Guest Order Tracking for WooCommerce - Section Settings
 *
 * @version 2.0.0
 * @since   2.0.0
 *
 * @author  WPFactory
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Guest_Order_Tracking_Settings_Section' ) ) :

class Alg_WC_Guest_Order_Tracking_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		add_filter( 'woocommerce_get_sections_alg_wc_guest_order_tracking',              array( $this, 'settings_section' ) );
		add_filter( 'woocommerce_get_settings_alg_wc_guest_order_tracking_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );
	}

	/**
	 * settings_section.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

}

endif;
