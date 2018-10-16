<?php
/*
Plugin Name: Guest Order Tracking for WooCommerce
Description: Makes it easier for unlogged users to access an WooCommerce order
Version: 1.0.1
Author: Algoritmika Ltd
Author URI: http://algoritmika.com
Copyright: © 2017 Algoritmika Ltd.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: guest-order-tracking-for-woocommerce
Domain Path: /languages
WC requires at least: 3.0.0
WC tested up to: 3.4
*/


add_action( 'plugins_loaded', 'alg_gotwc_start_plugin' );
if ( ! function_exists( 'alg_gotwc_start_plugin' ) ) {
	/**
	 * Starts the plugin
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alg_gotwc_start_plugin() {

		// Includes composer dependencies and autoloads classes
		require __DIR__ . '/vendor/autoload.php';

		// Initializes the plugin
		$plugin = new Alg_GOTWC_Core();
		$plugin->set_args( array(
			'file' => __FILE__,
		) );
		$plugin->init();


	}
}

