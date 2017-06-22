<?php
/**
 * Guest Order Tracking for WooCommerce - Core Class
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_GOTWC_Core' ) ) {

	class Alg_GOTWC_Core {

		public static $admin_general;
		public static $admin_tab;
		public static $plugin_basename;
		public static $args = array();

		/**
		 * Initializes
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function init() {
			// Translation
			$this->handle_localization();

			// Frontend
			$this->handle_frontend();

			// Admin
			$this->handle_admin();
		}

		/**
		 * Handle Frontend
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function handle_frontend() {
		    $frontend = new Alg_GOTWC_Frontend();
			add_action( 'template_redirect', array( $frontend, 'redirect_to_tracking' ) );
			add_action( 'wp_footer', array( $frontend, 'add_order_id_from_query_string_on_order_field' ) );
		}

		/**
		 * Gets admin settings
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @return Alg_GOTWC_Admin_Tab
		 */
		public static function get_admin_tab() {
			if ( ! self::$admin_tab ) {
				self::$admin_tab = new Alg_GOTWC_Admin_Tab();
			}
			return self::$admin_tab;
		}

		/**
		 * Gets admin General
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @return Alg_GOTWC_Admin_General
		 */
		public static function get_admin_general() {
			if ( ! self::$admin_general ) {
				self::$admin_general = new Alg_GOTWC_Admin_General();
			}
			return self::$admin_general;
		}

		/**
		 * Gets plugin basename
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function get_plugin_basename() {
			if ( ! self::$plugin_basename ) {
				self::$plugin_basename = plugin_basename( self::$args['file'] );
			}
			return self::$plugin_basename;
		}

		/**
		 * Sets args
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function set_args( $args ) {
		    self::$args = wp_parse_args( $args, array(
			    'file' => __FILE__,
		    ) );
		}

		/**
		 * Handle admin
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function handle_admin() {
			$admin_general = self::get_admin_general();
			$admin_tab = self::get_admin_tab();

			// Admin settings
			add_filter( "woocommerce_settings_tabs_array", array( $admin_tab, 'add_tab' ), 50 );
			add_action( "woocommerce_settings_tabs_{$admin_tab->admin_tab_id}", array( $admin_tab, 'settings_tab' ) );
			add_action( "woocommerce_update_options_{$admin_tab->admin_tab_id}", array( $admin_tab, 'update_settings' ) );

			// Plugin settings link
			add_filter( 'plugin_action_links_' . self::get_plugin_basename(), array( $admin_general, 'action_links' ) );
		}

		/**
		 * Handle Localization
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function handle_localization() {
			$file            = self::$args['file'];
			$plugin_basename = plugin_basename( $file );
			$dirname         = dirname( $plugin_basename );

			$locale = apply_filters( 'plugin_locale', get_locale(), 'guest-order-tracking-for-woocommerce' );
			load_textdomain( 'guest-order-tracking-for-woocommerce', WP_LANG_DIR . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR . 'guest-order-tracking-for-woocommerce' . '-' . $locale . '.mo' );
			load_plugin_textdomain( 'guest-order-tracking-for-woocommerce', false, $dirname . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR );
		}

	}
}