<?php
/*
Plugin Name: Guest Order Tracking for WooCommerce
Plugin URI: https://wordpress.org/plugins/guest-order-tracking-for-woocommerce/
Description: Makes it easier for unlogged users to access a WooCommerce order.
Version: 2.1.5
Author: WPFactory
Author URI: https://wpfactory.com
Text Domain: guest-order-tracking-for-woocommerce
Domain Path: /langs
WC requires at least: 3.0.0
WC tested up to: 8.6
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
	public $version = '2.1.5';

	/**
	 * @var   Alg_WC_Guest_Order_Tracking The single instance of the class
	 * @since 2.0.0
	 */
	protected static $_instance = null;

	/**
	 * $file_system_path.
	 *
	 * @since 2.1.4
	 */
	protected $file_system_path;

	/**
	 * Core.
	 *
	 * @since 2.1.4
	 *
	 * @var Alg_WC_Guest_Order_Tracking_Core
	 */
	public $core = null;

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
	 * Initializer.
	 *
	 * @version 2.1.4
	 * @since   2.0.0
	 *
	 * @access  public
	 */
	function init() {
		// Check for active plugins
		if ( ! $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			return;
		}

		// HPOS.
		add_action( 'before_woocommerce_init', array( $this, 'declare_compatibility_with_hpos' ) );

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
	 * declare_compatibility_with_hpos.
	 *
	 * @version 2.1.4
	 * @since   2.1.4
	 *
	 * @return void
	 */
	function declare_compatibility_with_hpos() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', $this->get_filesystem_path(), true );
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

	/**
	 * get_filesystem_path.
	 *
	 * @version 2.1.4
	 * @since   2.1.4
	 *
	 * @return string
	 */
	function get_filesystem_path() {
		return $this->file_system_path;
	}

	/**
	 * set_filesystem_path.
	 *
	 * @version 2.1.4
	 * @since   2.1.4
	 *
	 * @param   mixed  $file_system_path
	 */
	public function set_filesystem_path( $file_system_path ) {
		$this->file_system_path = $file_system_path;
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

$plugin = alg_wc_guest_order_tracking();
$plugin->set_filesystem_path( __FILE__ );
$plugin->init();
