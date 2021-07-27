<?php
/**
 * Guest Order Tracking for WooCommerce - Core Class
 *
 * @version 2.1.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Guest_Order_Tracking_Core' ) ) :

class Alg_WC_Guest_Order_Tracking_Core {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @todo    [next] (feature) auto-fill email (from session) (P)
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_guest_order_tracking_plugin_enabled', 'yes' ) ) {
			add_action( 'template_redirect', array( $this, 'redirect_to_tracking' ) );
			add_action( 'wp_footer',         array( $this, 'add_order_id_from_query_string_on_order_field' ) );
		}
	}

	/**
	 * Adds order id from query string on order field of the tracking page.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] (dev) move this to a separate `js` file
	 */
	function add_order_id_from_query_string_on_order_field() {
		if ( is_user_logged_in() || is_admin() ) {
			return;
		}
		?>
		<script>
			function alg_gotwc_get_urlvars() {
				var vars = [], hash;
				var hashes = window.location.href.slice( window.location.href.indexOf( '?' ) + 1 ).split( '&' );
				for ( var i = 0; i < hashes.length; i++ ) {
					hash = hashes[i].split( '=' );
					vars.push( hash[0] );
					vars[ hash[0] ] = hash[1];
				}
				return vars;
			}
			jQuery( document ).ready( function( $ ) {
				if ( $( 'form.track_order' ).length ) {
					var order_id = alg_gotwc_get_urlvars()['order_id'];
					if ( $( '#orderid' ).length ) {
						$( '#orderid' ).attr( 'value', order_id );
					}
				}
			} );
		</script>
		<?php
	}

	/**
	 * Redirects order to tracking page.
	 *
	 * @version 2.1.0
	 * @since   1.0.0
	 */
	function redirect_to_tracking() {
		if ( is_user_logged_in() || is_admin() ) {
			return;
		}
		global $wp_query;
		if ( ! isset( $wp_query->query['view-order'] ) ) {
			return;
		}
		$url   = apply_filters( 'alg_gotwc_tracking_page_url', esc_url( get_option( 'alg_gotwc_track_page_url', home_url( '/tracking/' ) ) ) );
		$order = wc_get_order( $wp_query->query['view-order'] );
		if ( $order ) {
			wp_redirect( add_query_arg( array( 'order_id' => $order->get_id() ), $url ) );
			exit();
		}
	}

}

endif;

return new Alg_WC_Guest_Order_Tracking_Core();
