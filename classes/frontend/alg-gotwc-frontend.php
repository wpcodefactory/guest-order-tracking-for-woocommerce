<?php
/**
 * Guest Order Tracking for WooCommerce - Frontend
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_GOTWC_Frontend' ) ) {

	class Alg_GOTWC_Frontend {

		/**
		 * Adds order id from query string on order field of the tracking page
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function add_order_id_from_query_string_on_order_field() {
			if (
				is_user_logged_in() ||
				is_admin()
			) {
				return;
			}

			?>
            <script>
				function alg_gotwc_get_urlvars() {
					var vars = [], hash;
					var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
					for (var i = 0; i < hashes.length; i++) {
						hash = hashes[i].split('=');
						vars.push(hash[0]);
						vars[hash[0]] = hash[1];
					}
					return vars;
				}
				jQuery(document).ready(function ($) {
					if ($('form.track_order').length) {
						var order_id = alg_gotwc_get_urlvars()['order_id'];
						if ($("#orderid").length) {
							$('#orderid').attr('value', order_id);
						}
					}
				});
            </script>
			<?php
		}

		/**
		 * Redirects order to tracking page
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function redirect_to_tracking() {
			if (
				is_user_logged_in() ||
				is_admin()
			) {
				return;
			}

			global $wp_query;
			if ( ! isset( $wp_query->query['view-order'] ) ) {
				return;
			}

			$admin_settings   = new Alg_GOTWC_Admin_Tab();
			$url_for_tracking = apply_filters( 'alg_gotwc_tracking_page_url', esc_url( get_option( $admin_settings->option_track_page_url ) ) );
			$order            = wc_get_order( $wp_query->query['view-order'] );
			if ( $order ) {
				$final_tracking_page_url = add_query_arg( array(
					'order_id' => $order->get_order_number(),
				), $url_for_tracking );

				wp_redirect( $final_tracking_page_url );
				exit();
			}
		}
	}
}




