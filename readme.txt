=== Guest Order Tracking for WooCommerce ===
Contributors: algoritmika,karzin,anbinder
Tags: woocommerce,order,tracking,unlogged,guest
Requires at least: 4.4
Tested up to: 4.7
Stable tag: 1.2.8
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Makes it easier for unlogged users to access an WooCommerce order

== Description ==

**Guest Order Tracking for WooCommerce** makes it easier for unlogged users to access an WooCommerce order.

Once you activate and setup this plugin, if an unlogged user tries to access an order page, it will be redirected to the tracking order page having the order field already filled

== Frequently Asked Questions ==

= How the plugin works? =
When an unlogged user tries to access an order page url like **http://site.com/my-account/view-order/123/** , nothing happens.
Once you activate and setup this plugin, instead of nothing, you'll be redirected to the tracking order page having the order field already filled

= How to use this plugin? =
Simply follow these steps:
1. Create a page and add this shortcode [woocommerce_order_tracking]
2. Ctrl+C the permalink of this page
3. Go to your plugin settings on **WooCommerce > Settings > Guest order tracking**
4. Paste your permalink on **Tracking page url** option and **save changes**

= Are there any filters available? =
**alg_gotwc_tracking_page_url** - Filters the tracking page url

= How can I contribute? Is there a github repository? =
If you are interested in contributing - head over to the [Guest Order Tracking for WooCommerce plugin GitHub Repository](https://github.com/algoritmika/guest-order-tracking-for-woocommerce) to find out how you can pitch in.

== Installation ==

1. Upload the entire 'guest-order-tracking-for-woocommerce' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Start by visiting plugin settings at WooCommerce > Settings > Wish List.

== Changelog ==

= 1.0.0 - 22/06/2017 =
* Initial Release.

== Upgrade Notice ==

= 1.0.0 =
* Initial Release.