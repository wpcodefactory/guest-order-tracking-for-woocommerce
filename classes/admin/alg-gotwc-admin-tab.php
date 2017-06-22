<?php
/**
 * Guest Order Tracking for WooCommerce - Admin tab
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_GOTWC_Admin_Tab' ) ) {

	class Alg_GOTWC_Admin_Tab {

		public $admin_tab_id = 'alg_gotwc_tab';
		public $option_track_page_url = 'alg_gotwc_track_page_url';

		/**
		 * Initializes
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function init() {

		}

		/**
		 * Update settings
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function update_settings() {
			woocommerce_update_options( $this->get_settings() );
		}

		/**
		 * Creates settings
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function settings_tab() {
			woocommerce_admin_fields( $this->get_settings() );
		}

		/**
		 * Gets settings
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function get_settings() {
			$settings = array(
				array(
					'name' => __( 'Guest Order tracking options', 'guest-order-tracking-for-woocommerce' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'alg_gotwc_general_opt',
				),
				array(
					'name'  => __( 'Tracking page url', 'guest-order-tracking-for-woocommerce' ),
					'type'  => 'text',
					'class' => 'regular-input',
					'default' => home_url( '/tracking/' ) ,
					'desc'  => __( 'The url of the tracking page', 'guest-order-tracking-for-woocommerce' ),
					'id'    => $this->option_track_page_url,
				),
				array(
					'type' => 'sectionend',
					'id'   => 'alg_gotwc_general_opt',
				),
			);
			return apply_filters( "wc_{$this->admin_tab_id}_settings", $settings );
		}

		/**
		 * Adds tab
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function add_tab( $settings_tabs ) {
			$settings_tabs[ $this->admin_tab_id ] = __( 'Guest order tracking', 'guest-order-tracking-for-woocommerce' );
			return $settings_tabs;
		}
	}
}