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
 * @package           Mwpl-woo-product-specifications
 *
 * @wordpress-plugin
 * Plugin Name:       MWPL Woo Product Specifications
 * Plugin URI:        http://www.maansawebworld.com
 * Description:       Product Specifications
 * Version:           1.0.0
 * Author:            Maansa Webworld Pvt Ltd.
 * Author URI:        http://www.maansawebworld.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mwpl_woo_product_specifications
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

require plugin_dir_path( __FILE__ ) .'plugin-updates/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://www.maansawebworld.com/update-package/plugins/woocommerce/specification/details.json', //Metadata URL.
	__FILE__, //Full path to the main plugin file.
	'mwpl_woo_product_specifications' //Plugin slug. Usually it's the same as the name of the directory.
);

define('DIRECTORY_SEPARATOR', '/');
define('PRD_DIR', basename( dirname(__FILE__) ));
define('PRD_ROOT_PATH',  dirname(__FILE__).DIRECTORY_SEPARATOR);
define('PRD_INCLUDES_PATH',PRD_ROOT_PATH.'includes/');
define('PRD_ADMIN_PATH',PRD_ROOT_PATH.'admin/');
define('PRD_PUBLIC_PATH',PRD_ROOT_PATH.'public/');
define('PRD_PLUGIN_URL', plugins_url(PRD_DIR));
define('PRD_ADMIN_URL', PRD_PLUGIN_URL.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR);
define('PRD_PUBLIC_URL', PRD_PLUGIN_URL.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mwpl-main.php';
function run_mwpl_link_generator() {
    $plugin = new Mwpl_Woo_Product_Specifications();
}
run_mwpl_link_generator();
