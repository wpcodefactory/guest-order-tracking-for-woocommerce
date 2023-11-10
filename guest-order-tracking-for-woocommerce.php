<?php
/*
Plugin Name: Guest Order Tracking for WooCommerce
Plugin URI: https://wordpress.org/plugins/guest-order-tracking-for-woocommerce/
Description: Makes it easier for unlogged users to access a WooCommerce order.
Version: 2.1.3
Author: WPFactory
Author URI: https://wpfactory.com
Text Domain: guest-order-tracking-for-woocommerce
Domain Path: /langs
WC requires at least: 3.0.0
WC tested up to: 8.2
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Guest_Order_Tracking' ) ) :

/**
 * Main Alg_WC_Guest_Order_Tracking Class
 *
 * @version 2.1.1
 * @since   2.0.0
 *
 * @class   Alg_WC_Guest_Order_Tracking
 */
final class Alg_WC_Guest_Order_Tracking {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 2.0.0
	 */
	public $version = '2.1.3';

	/**
	 * @var   Alg_WC_Guest_Order_Tracking The single instance of the class
	 * @since 2.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_Guest_Order_Tracking Instance
	 *
	 * Ensures only one instance of Alg_WC_Guest_Order_Tracking is loaded or can be loaded.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @static
	 * @return  Alg_WC_Guest_Order_Tracking - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_Guest_Order_Tracking Constructor.
	 *
	 * @version 2.1.1
	 * @since   2.0.0
	 *
	 * @access  public
	 */
	function __construct() {

		// Check for active plugins
		if ( ! $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			return;
		}

		// Set up localisation
		add_action( 'init', array( $this, 'localize' ) );

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}

	}

	/**
	 * is_plugin_active.
	 *
	 * @version 2.1.0
	 * @since   2.1.0
	 */
	function is_plugin_active( $plugin ) {
		return ( function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) :
			(
				in_array( $plugin, apply_filters( 'active_plugins', ( array ) get_option( 'active_plugins', array() ) ) ) ||
				( is_multisite() && array_key_exists( $plugin, ( array ) get_site_option( 'active_sitewide_plugins', array() ) ) )
			)
		);
	}

	/**
	 * localize.
	 *
	 * @version 2.1.1
	 * @since   2.1.1
	 */
	function localize() {
		load_plugin_textdomain( 'guest-order-tracking-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
	}

	/**
	 * includes.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function includes() {
		$this->core = require_once( 'includes/class-alg-wc-guest-order-tracking-core.php' );
	}

	/**
	 * admin.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		// Version update
		if ( get_option( 'alg_wc_guest_order_tracking_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * action_links.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_guest_order_tracking' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		return array_merge( $custom_links, $links );
	}

	/**
	 * add_woocommerce_settings_tab.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'includes/settings/class-alg-wc-guest-order-tracking-settings.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function version_updated() {
		update_option( 'alg_wc_guest_order_tracking_version', $this->version );
	}

	/**
	 * plugin_url.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * plugin_path.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_wc_guest_order_tracking' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Guest_Order_Tracking to prevent the need to use globals.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @return  Alg_WC_Guest_Order_Tracking
	 *
	 * @todo    [maybe] (dev) `plugins_loaded`
	 */
	function alg_wc_guest_order_tracking() {
		return Alg_WC_Guest_Order_Tracking::instance();
	}
}

alg_wc_guest_order_tracking();
