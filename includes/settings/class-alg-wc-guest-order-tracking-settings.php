<?php
/**
 * Guest Order Tracking for WooCommerce - Settings
 *
 * @version 2.1.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Guest_Order_Tracking_Settings' ) ) :

class Alg_WC_Guest_Order_Tracking_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id    = 'alg_wc_guest_order_tracking';
		$this->label = __( 'Guest Order Tracking', 'guest-order-tracking-for-woocommerce' );
		parent::__construct();
		// Sections
		require_once( 'class-alg-wc-guest-order-tracking-settings-section.php' );
		require_once( 'class-alg-wc-guest-order-tracking-settings-general.php' );
	}

	/**
	 * get_settings.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function get_settings() {
		global $current_section;
		return array_merge( apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $current_section, array() ), array(
			array(
				'title'     => __( 'Reset Settings', 'guest-order-tracking-for-woocommerce' ),
				'type'      => 'title',
				'id'        => $this->id . '_' . $current_section . '_reset_options',
			),
			array(
				'title'     => __( 'Reset section settings', 'guest-order-tracking-for-woocommerce' ),
				'desc'      => '<strong>' . __( 'Reset', 'guest-order-tracking-for-woocommerce' ) . '</strong>',
				'desc_tip'  => __( 'Check the box and save changes to reset.', 'guest-order-tracking-for-woocommerce' ),
				'id'        => $this->id . '_' . $current_section . '_reset',
				'default'   => 'no',
				'type'      => 'checkbox',
			),
			array(
				'type'      => 'sectionend',
				'id'        => $this->id . '_' . $current_section . '_reset_options',
			),
		) );
	}

	/**
	 * maybe_reset_settings.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function maybe_reset_settings() {
		global $current_section;
		if ( 'yes' === get_option( $this->id . '_' . $current_section . '_reset', 'no' ) ) {
			foreach ( $this->get_settings() as $value ) {
				if ( isset( $value['id'] ) ) {
					$id = explode( '[', $value['id'] );
					delete_option( $id[0] );
				}
			}
			if ( method_exists( 'WC_Admin_Settings', 'add_message' ) ) {
				WC_Admin_Settings::add_message( __( 'Your settings have been reset.', 'guest-order-tracking-for-woocommerce' ) );
			} else {
				add_action( 'admin_notices', array( $this, 'admin_notices_settings_reset_success' ), PHP_INT_MAX );
			}
		}
	}

	/**
	 * admin_notices_settings_reset_success.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function admin_notices_settings_reset_success() {
		echo '<div class="notice notice-success is-dismissible"><p><strong>' .
			__( 'Your settings have been reset.', 'guest-order-tracking-for-woocommerce' ) . '</strong></p></div>';
	}

	/**
	 * save.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function save() {
		parent::save();
		$this->maybe_reset_settings();
	}

}

endif;

return new Alg_WC_Guest_Order_Tracking_Settings();
