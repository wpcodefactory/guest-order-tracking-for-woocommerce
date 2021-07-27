<?php
/**
 * Guest Order Tracking for WooCommerce - General Section Settings
 *
 * @version 2.0.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Guest_Order_Tracking_Settings_General' ) ) :

class Alg_WC_Guest_Order_Tracking_Settings_General extends Alg_WC_Guest_Order_Tracking_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'guest-order-tracking-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @todo    [maybe] (dev) remove `wc_alg_gotwc_tab_settings` filter
	 */
	function get_settings() {

		$plugin_settings = array(
			array(
				'title'    => __( 'Guest Order Tracking Options', 'guest-order-tracking-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_guest_order_tracking_plugin_options',
			),
			array(
				'title'    => __( 'Guest Order Tracking', 'guest-order-tracking-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'guest-order-tracking-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_guest_order_tracking_plugin_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'name'     => __( 'Tracking page URL', 'guest-order-tracking-for-woocommerce' ),
				'desc'     => __( 'The URL of the tracking page.', 'guest-order-tracking-for-woocommerce' ) . ' ' .
					sprintf( __( 'Create a page and add %s shortcode there. Then copy page link here.', 'guest-order-tracking-for-woocommerce' ),
						'<code>[woocommerce_order_tracking]</code>' ),
				'id'       => 'alg_gotwc_track_page_url',
				'type'     => 'text',
				'class'    => 'regular-input',
				'default'  => home_url( '/tracking/' ),
				'css'      => 'width:100%;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_guest_order_tracking_plugin_options',
			),
		);

		return apply_filters( 'wc_alg_gotwc_tab_settings', array_merge( $plugin_settings ) );
	}

}

endif;

return new Alg_WC_Guest_Order_Tracking_Settings_General();
