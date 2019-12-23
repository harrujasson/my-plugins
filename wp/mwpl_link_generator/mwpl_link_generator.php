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
 * @package           Mwpl_link_generator
 *
 * @wordpress-plugin
 * Plugin Name:       Link Generator
 * Plugin URI:        http://www.maansawebworld.com
 * Description:       Link generation
 * Version:           4.1.0
 * Author:            Maansa Webworld Pvt Ltd.
 * Author URI:        http://www.maansawebworld.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mwpl_link_generator
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
define( 'PLUGIN_NAME_VERSION', '4.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwpl_link_generator-activator.php
 */
function activate_mwpl_link_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwpl_link_generator-activator.php';
	Mwpl_link_generator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwpl_link_generator-deactivator.php
 */
function deactivate_mwpl_link_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwpl_link_generator-deactivator.php';
	Mwpl_link_generator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mwpl_link_generator' );
register_deactivation_hook( __FILE__, 'deactivate_mwpl_link_generator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path( __FILE__ ) .'plugin-updates/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://www.maansawebworld.com/update-package/plugins/casinobono/link-generation/details.json', //Metadata URL.
	__FILE__, //Full path to the main plugin file.
	'mwpl_link_generator' //Plugin slug. Usually it's the same as the name of the directory.
);

require plugin_dir_path( __FILE__ ) . 'includes/class-mwpl_link_generator.php';
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
function run_mwpl_link_generator() {

	$plugin = new Mwpl_link_generator();
	$plugin->run();

}
run_mwpl_link_generator();
