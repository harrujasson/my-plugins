<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.maansawebworld.com/
 * @since             1.0.0
 * @package           Mwpl_tours_managment
 *
 * @wordpress-plugin
 * Plugin Name:       Tour Managment
 * Plugin URI:        http://www.maansawebworld.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Talwinder Singh
 * Author URI:        https://www.maansawebworld.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mwpl_tours_managment
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
define( 'MWPL_TOURS_MANAGMENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwpl_tours_managment-activator.php
 */
function activate_mwpl_tours_managment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwpl_tours_managment-activator.php';
	Mwpl_tours_managment_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwpl_tours_managment-deactivator.php
 */
function deactivate_mwpl_tours_managment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwpl_tours_managment-deactivator.php';
	Mwpl_tours_managment_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mwpl_tours_managment' );
register_deactivation_hook( __FILE__, 'deactivate_mwpl_tours_managment' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mwpl_tours_managment.php';
/*Common Constant*/
define('PRD_DIR', basename( dirname(__FILE__) ));
define('PRD_ROOT_PATH',  dirname(__FILE__).DIRECTORY_SEPARATOR);
define('PRD_INCLUDES_PATH',PRD_ROOT_PATH.'includes/');
define('PRD_ADMIN_PATH',PRD_ROOT_PATH.'admin/');
define('PRD_PUBLIC_PATH',PRD_ROOT_PATH.'public/');
define('PRD_PLUGIN_URL', plugins_url(PRD_DIR));
define('PRD_PLUGIN_URL_ADMIN', PRD_PLUGIN_URL.DIRECTORY_SEPARATOR.'admin/');
define('PRD_PLUGIN_URL_PUBLIC', PRD_PLUGIN_URL.DIRECTORY_SEPARATOR.'public/');
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mwpl_tours_managment() {

	$plugin = new Mwpl_tours_managment();
	$plugin->run();

}
run_mwpl_tours_managment();
