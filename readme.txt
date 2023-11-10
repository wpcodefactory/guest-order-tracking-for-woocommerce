=== Guest Order Tracking for WooCommerce ===
Contributors: wpcodefactory, omardabbas, karzin, anbinder, algoritmika, kousikmukherjeeli
Tags: woocommerce, order, tracking, unlogged, guest, woo commerce
Requires at least: 4.4
Tested up to: 6.4
Stable tag: 2.1.2
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Makes it easier for unlogged users to access a WooCommerce order.

== Description ==

**Guest Order Tracking for WooCommerce** makes it easier for unlogged users to access a WooCommerce order.

Once you activate and setup this plugin, if an unlogged user tries to access an order page, he will be redirected to the tracking order page having the order field already filled.

== Frequently Asked Questions ==

= How does the plugin work? =

By default, when unlogged users try to access an order page URL like `http://example.com/my-account/view-order/123/`, nothing happens. Once you activate and set up this plugin, users will be redirected to the tracking order page having the order field already filled.

= How to use this plugin? =

Simply follow these steps:

1. Create a page and add this shortcode: `[woocommerce_order_tracking]`.
2. Copy the permalink of this page.
3. Go to your plugin settings in "WooCommerce > Settings > Guest Order Tracking".
4. Paste your permalink to "Tracking page URL" option and "Save changes".

= Are there any filters available? =

`alg_gotwc_tracking_page_url` - Filters the tracking page URL.

= How can I contribute? Is there a GitHub repository? =

If you are interested in contributing - head over to the [Guest Order Tracking for WooCommerce plugin GitHub repository](https://github.com/algoritmika/guest-order-tracking-for-woocommerce) to find out how you can pitch in.

== Installation ==

1. Upload the entire plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Start by visiting plugin settings at "WooCommerce > Settings > Guest Order Tracking".

== Changelog ==

= 2.1.3 - 10/11/2023 =
* Tested up to: 6.4
* WC tested up to: 8.2
* Move to WPFactory.
* Dev - Add github deploy setup.

= 2.1.2 - 27/07/2021 =
* Tested up to: 5.8.
* WC tested up to: 5.5.

= 2.1.1 - 12/03/2021 =
* Dev - Localisation - `load_plugin_textdomain()` moved to the `init` hook.
* Tested up to: 5.7.
* WC tested up to: 5.1.

= 2.1.0 - 27/03/2020 =
* Fix - Using `get_id()` instead of `get_order_number()` now (i.e. unfiltered).
* Fix - "Reset settings" admin notice fixed.
* Dev - Admin settings descriptions updated.
* Dev - Code refactoring.
* WC tested up to: 4.0.
* Tested up to: 5.3.

= 2.0.0 - 24/07/2019 =
* Dev - Major code refactoring.

= 1.0.1 - 16/10/2018 =
* Get default tracking page in case it hasn't been set.
* Add WooCommerce requirements.

= 2.0.0 - 22/06/2017 =
* Initial Release.

== Upgrade Notice ==

= 2.0.0 =
This is the first release of the plugin.
