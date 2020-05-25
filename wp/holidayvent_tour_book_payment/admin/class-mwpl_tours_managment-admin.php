<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/admin
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */
class Mwpl_tours_managment_Admin {

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
        use MWPL_Roles;
        use MPWL_Authorized;
        use MWPL_Common;
        private $current_user_role;
        private $current_user_id;
        private $ticket_manage_loader;
        private $ticket_manage_loader_executive;
        private $ticket_manage_loader_authorized;
        private $customer;
        
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                
                /*Permission to executive*/
                add_action( 'admin_init', array($this,'add_capability'));
                
                /*Create the the admin menu */
                add_action("admin_menu",array($this,"menu_generation"));
                
                /*Set user roles variables*/
                $this->set_user_role();
                $this->current_user_role = $this->get_user_role_information('role');
                $this->current_user_id = $this->get_user_role_information('user_id');
                
                
                
                
                
                /*Methods Loading*/
                $this->methods_loading();
                
                /*Catch all request by form submit*/
                $this->catch_request();

                
                
                /*Customer account*/
                add_shortcode( 'mwpl-customer-account-dashboard', array(&$this,'account_customer_load') );
                
                /*Rewrite URL for customer*/
                add_action( 'init', array(&$this,'custom_rewrite_rule') );

	}
        function custom_rewrite_rule() {
          add_rewrite_rule('customer-account/?([^/]*)/([^/]*)', 'index.php?pagename=customer-account&node_first=$matches[1]&node_second=$matches[2]', 'top');
          add_rewrite_rule('tour-payment/?([^/]*)', 'index.php?pagename=tour-payment&node_first=$matches[1]', 'top');
          add_filter( 'query_vars', function( $vars ){
                  $vars[] = 'node_first';       
                  $vars[] = 'node_second';       
                  return $vars;
          });
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
		 * defined in Mwpl_tours_managment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwpl_tours_managment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwpl_tours_managment-admin.css', array(), $this->version, 'all' );

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
		 * defined in Mwpl_tours_managment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwpl_tours_managment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mwpl_tours_managment-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        
        function menu_generation(){
            /*Admin menu links*/
            global $current_user;            
            if ( in_array( $current_user->roles[0], array( 'administrator' ) ) ) {                
                add_menu_page("Tours Orders", "Tours Orders", "manage_options", "mwpl_order",array(&$this,"manage_tours"),'dashicons-cart');
                add_submenu_page(null, "Order - View", "", "manage_options", "mwpl_order_view",array(&$this,"order_view"));
                add_submenu_page("mwpl_order", "Settings", "Settings", "manage_options", "mwpl_order_settings",array(&$this,"settings"));
            }
            
            if ( in_array( $current_user->roles[0], array( 'tour_executive' ) ) ) {
                /*Manager menu links*/
                add_menu_page("Tours Orders", "Tours Orders", "manager_access_only", "mwpl_order_executive",array(&$this,"manage_tours_executive"),'dashicons-cart');
                add_submenu_page(null, "Order - View", "", "manager_access_only", "mwpl_order_view_executive",array(&$this,"order_view_executive"));
            }
        }
        function add_capability() {
            $shop_manager_role = get_role( 'tour_executive' );           
            if($shop_manager_role!=""){
                $shop_manager_role->add_cap( 'manager_access_only' ); 
            }
        }
         
        function methods_loading(){
            /*For admin*/
            if($this->role == "administrator" ){
                require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/administrator/class-mwpl-manage.php';
                $this->ticket_manage_loader = new  MWPL_Administrator($this->current_user_id, $this->current_user_role);
            }
            
            /*For Executive*/
            if($this->role == "tour_executive" ){
                require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/executive/class-mwpl-manage.php';
                $this->ticket_manage_loader_executive = new  MWPL_Executive($this->current_user_id, $this->current_user_role);
            }
            
            if($this->role != "" ){
            /*For Authorized*/
            require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwpl_tours_managment-authorized.php';
            $this->ticket_manage_loader_authorized = new  MWPL_Common_Authorized($this->current_user_id, $this->current_user_role);
            }
            
            /*For customer account*/
            //echo '<a href="'.wp_logout_url( site_url('customer-account-login') ).'">Logout</a>'; 
            if($this->role == "customer" ){
                add_filter('show_admin_bar', '__return_false');
                require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/customer/class-mwpl-customer.php';
                $this->customer = new MWPL_Customer_Account($this->current_user_id, $this->current_user_role);
            }
        }
        
        function catch_request(){
            /*Customer*/
            if(isset($_POST['ticket_create_authorized'])){
                $this->is_customer_authorized($this->current_user_role);
                $this->customer->generate_ticket();
            }
            
            /*Admin action*/            
            if(isset($_POST['settings_admin'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->settings_save();
            }
            if(isset($_POST['assign_order_executive'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->assign_order();
            }
            
            /*Authorized administator*/
            if(isset($_POST['order_status_update'])){
                $this->is_authorized_administator($this->current_user_role);
                $this->ticket_manage_loader_authorized->order_upate();
            }
            
            
            /*Common Authorized*/
            if(isset($_POST['ticket_reopen'])){
                $this->is_authorized($this->current_user_role);
                $this->ticket_reopen();
            }
           
        }
        
        /*Admin*/
        function manage_tours(){
            $this->ticket_manage_loader->show();
        }
        function order_view(){
            $this->ticket_manage_loader->details();
        }
        function settings(){
            $this->ticket_manage_loader->settings();
        }
        
        /*Executive*/
        function manage_tours_executive(){
            $this->ticket_manage_loader_executive->show();
        }
        function order_view_executive(){
            $this->ticket_manage_loader_executive->details();
        }
        
        /*Customer*/       
        function account_customer_load(){ 
            if(is_admin()){
                return false;
            }
            $this->is_customer_authorized($this->current_user_role);
            $this->customer->load_module();
        }

}
