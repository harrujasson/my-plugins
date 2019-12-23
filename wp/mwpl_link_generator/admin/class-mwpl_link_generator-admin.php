<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.maansawebworld.com
 * @since      1.0.0
 *
 * @package    Mwpl_link_generator
 * @subpackage Mwpl_link_generator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwpl_link_generator
 * @subpackage Mwpl_link_generator/admin
 * @author     Maansa Webworld Pvt Ltd. <info@maansawebworld.com>
 */
class Mwpl_link_generator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
        
       
        
        
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;                
                add_action('admin_menu',array($this,'menu_generation'));
                add_shortcode('mwpl_link_gen', array($this,'mwpl_shortcode'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mwpl_link_generator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwpl_link_generator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */            
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwpl_link_generator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mwpl_link_generator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwpl_link_generator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mwpl_link_generator-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        function menu_generation(){              
           add_menu_page('Link Generation', 'Link Generation', 'manage_options', 'mwpl_link_generation', array($this,'manage_links')); 
           add_submenu_page(null, "", "", "manage_options", "mwpl_link_generation_new",array($this,'add_new_link'),'');
           add_submenu_page(null, "", "", "manage_options", "mwpl_link_generation_edit",array($this,'edit_link'),'');
           add_submenu_page('mwpl_link_generation', "Heading Text", "Heading Text", "manage_options", "mwpl_link_generation_heading",array($this,'add_new_heading'),'');
        }
        function manage_links(){
            require_once PRD_ADMIN_PATH.'class-manage.php';             
            $mwpl_manage=new MWPL_MANAGE();    
            $mwpl_manage->load_list();
        }
        function add_new_link(){
            require_once PRD_ADMIN_PATH.'class-manage.php';             
            $mwpl_new=new MWPL_MANAGE(); 
            $mwpl_new->load_new();
        }
        function edit_link(){
            require_once PRD_ADMIN_PATH.'class-manage.php';             
            $mwpl_new=new MWPL_MANAGE(); 
            $mwpl_new->load_edit();
        }
        function mwpl_shortcode(){               
            require_once PRD_ADMIN_PATH.'class-shortcode.php'; 
            $mwpl_new=new MWPL_Shortcode(); 
            return $mwpl_new->load_record();               
        }
        function add_new_heading(){
            require_once PRD_ADMIN_PATH.'class-manage.php';             
            $mwpl_new=new MWPL_MANAGE(); 
            $mwpl_new->load_heading();
        }
        

}
