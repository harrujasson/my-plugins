<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.maansawebworld.com
 * @since             1.0.0
 * @package           Mwpl-woo-quick-buy
 *
 * @wordpress-plugin
 * Plugin Name:       MWPL Woo Quick Buy
 * Plugin URI:        http://www.maansawebworld.com
 * Description:       Product Quick Buy
 * Version:           1.0.0
 * Author:            Maansa Webworld Pvt Ltd.
 * Author URI:        http://www.maansawebworld.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mwpl_woo_quick_buy
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );


/*Update plugin from one centre point*/


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
require plugin_dir_path( __FILE__ ) . 'class-main.php';
function run_mwpl_woo_quick_buy() {
    $plugin = new Mwpl_Woo_Quick_Buy();
}
run_mwpl_woo_quick_buy();
