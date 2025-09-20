<?php
/**
 * Plugin Name: X Woodokan
 * Plugin URI:  https://welabs.dev
 * Description: Here We extend and customize WooCommerce and Dokan features.
 * Version: 0.0.1
 * Author: WeLabs
 * Author URI: https://welabs.dev
 * Text Domain: x-woodokan
 * WC requires at least: 5.0.0
 * Domain Path: /languages/
 * Requires Plugins: woocommerce, dokan-lite, dokan-pro
 * License: GPL2
 */
use WeLabs\XWoodokan\XWoodokan;

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'X_WOODOKAN_FILE' ) ) {
    define( 'X_WOODOKAN_FILE', __FILE__ );
}

if ( ! defined( 'X_WOODOKAN_BASENAME' ) ) {
    define( 'X_WOODOKAN_BASENAME', plugin_basename( __FILE__ ) );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load X_Woodokan Plugin when all plugins loaded
 *
 * @return \WeLabs\XWoodokan\XWoodokan
 */
function welabs_x_woodokan() {
    return XWoodokan::init();
}

// Lets Go....
welabs_x_woodokan();
