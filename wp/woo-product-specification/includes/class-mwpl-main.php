<?php
class Mwpl_Woo_Product_Specifications {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mwpl_link_generator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mwpl_woo_product_specifications';

		$this->load_dependencies();
	}
	private function load_dependencies() {
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwpl-admin.php';
            $admin = new Mwpl_Woo_Product_Specifications_Admin();
            
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mwpl-public.php';
            $public = new Mwpl_Woo_Product_Specifications_Public();
            
	}
}
