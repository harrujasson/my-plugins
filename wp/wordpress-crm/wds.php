<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webdesign-studenten.nl/
 * @since             1.0.0
 * @package           Wds
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Support Tickets
 * Plugin URI:        https://webdesign-studenten.nl/
 * Description:       Easy Support Tickets
 * Version:           1.0.0
 * Author:            Webdesign studenten
 * Author URI:        https://webdesign-studenten.nl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wds
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
define( 'WDS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wds-activator.php
 */
function activate_wds() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wds-activator.php';
	Wds_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wds-deactivator.php
 */
function deactivate_wds() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wds-deactivator.php';
	Wds_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wds' );
register_deactivation_hook( __FILE__, 'deactivate_wds' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wds.php';


/*Common Constant*/
define('PRD_DIR', basename( dirname(__FILE__) ));
define('PRD_ROOT_PATH',  dirname(__FILE__).DIRECTORY_SEPARATOR);
define('PRD_INCLUDES_PATH',PRD_ROOT_PATH.'includes/');
define('PRD_ADMIN_PATH',PRD_ROOT_PATH.'admin/');
define('PRD_PUBLIC_PATH',PRD_ROOT_PATH.'public/');
define('PRD_PLUGIN_URL', plugins_url(PRD_DIR));
define('PRD_PLUGIN_URL_ADMIN', PRD_PLUGIN_URL.DIRECTORY_SEPARATOR.'admin/');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wds() {

	$plugin = new Wds();
	$plugin->run();

}
run_wds();




