<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webdesign-studenten.nl/
 * @since      1.0.0
 *
 * @package    Wds
 * @subpackage Wds/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wds
 * @subpackage Wds/admin
 * @author     Webdesign studenten <info@webdesign-studenten.nl>
 */
class Wds_Admin  {

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
        use WDS_Roles;
        use Wds_Authorized;
        use WDS_Common;
        private $current_user_role;
        private $current_user_id;
        private $ticket_manage_loader;
        private $ticket_manage_loader_manager;
        private $customer;
        private $ticket_manage_loader_canned;
        private $table_canned='';
       
        
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                
                /*Set user roles variables*/
                $this->set_user_role();
                $this->current_user_role = $this->get_user_role_information('role');
                $this->current_user_id = $this->get_user_role_information('user_id');
                
                /*Create the the admin menu */
                add_action("admin_menu",array($this,"menu_generation"));
                
                /*Canned fetch ajax*/
                add_action('wp_ajax_cannedfetchlist',array(&$this,'cannedfetchlist'));
                add_action('wp_ajax_nopriv_cannedfetchlist',array(&$this,'cannedfetchlist'));
                
                
                /*Methods Loading*/
                $this->methods_loading();
                
                /*Catch all request by form submit*/
                $this->catch_request();

                /*Permission to shop manager*/
                add_action( 'admin_init', array($this,'add_capability'));
                
                /*Customer account*/
                add_shortcode( 'wds-customer-ticket-dashboard', array(&$this,'account_customer_load') );
                
                /*Rewrite URL for customer*/
                add_action( 'init', array(&$this,'custom_rewrite_rule') );
                
                
                /*Table*/
                global $wpdb;
                $this->table_canned = $wpdb->prefix."mwpl_canned";

	}

        function custom_rewrite_rule() {
          add_rewrite_rule('customer-ticket/?([^/]*)/([^/]*)', 'index.php?pagename=customer-ticket&node_first=$matches[1]&node_second=$matches[2]', 'top');
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
		 * defined in Wds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wds-admin.css', array(), $this->version, 'all' );
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
		 * defined in Wds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wds-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        function menu_generation(){
            /*Admin menu links*/
            global $current_user;
            if ( in_array( $current_user->roles[0], array( 'administrator' ) ) ) {
                add_menu_page("Ticket", "Ticket", "manage_options", "mwpl_ticket",array(&$this,"manage_ticket"),'dashicons-admin-comments');
                add_submenu_page(null, "Discussion", "", "manage_options", "mwpl_ticket_discussion",array(&$this,"manage_ticket_discussion_admin"));
                add_submenu_page("mwpl_ticket", "Merge Ticket", "Merge Ticket", "manage_options", "mwpl_ticket_merge_ticket",array(&$this,"manage_ticket_merge_ticket"));
                add_submenu_page("mwpl_ticket", "History", "History", "manage_options", "mwpl_ticket_history",array(&$this,"manage_ticket_history"));
                
                add_submenu_page("mwpl_ticket", "Canned", "Canned", "manage_options", "mwpl_ticket_canned",array(&$this,"canned"));
                add_submenu_page(null, "Canned - Add new", "", "manage_options", "mwpl_ticket_canned_new",array(&$this,"canned_create"));
                add_submenu_page(null, "Canned - Add new", "", "manage_options", "mwpl_ticket_canned_edit",array(&$this,"canned_edit"));
                add_submenu_page(null, "Canned - Add new", "", "manage_options", "mwpl_ticket_canned_delete",array(&$this,"canned_delete"));
                
                add_submenu_page("mwpl_ticket", "Settings", "Settings", "manage_options", "mwpl_ticket_settings",array(&$this,"settings"));
                add_submenu_page("mwpl_ticket", "Fetch Email Tickets", "Fetch Email Tickets", "manage_options", "mwpl_ticket_emails",array(&$this,"emails_ticket"));
                
            }
            
            if ( in_array( $current_user->roles[0], array( 'ticket_manager' ) ) ) {
                /*Manager menu links*/
                add_menu_page("Ticket", "Ticket", "manager_access_only", "mwpl_ticket_customer",array(&$this,"manage_ticket_manager"),'dashicons-admin-comments');
                add_submenu_page(null, "Discussion", "", "manager_access_only", "mwpl_ticket_customer_discussion",array(&$this,"manage_ticket_discussion"));
                add_submenu_page("mwpl_ticket_customer", "History", "History", "manager_access_only", "mwpl_ticket_history_customer",array(&$this,"manage_ticket_history"));
            }
        }
        function add_capability() {
            $shop_manager_role = get_role( 'ticket_manager' );
            $shop_manager_role->add_cap( 'manager_access_only' ); 
        }
         
        function methods_loading(){
            
            /*For admin*/
            require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/manage_admin/class-wds-manage_ticket.php';
            $this->ticket_manage_loader = new  WDS_Admin_Manage_Ticket($this->current_user_id, $this->current_user_role);
            
            require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/manage_admin/class-wds-manage_canned.php';
            $this->ticket_manage_loader_canned = new  WDS_Admin_Manage_Canned($this->current_user_id, $this->current_user_role);
            
            
            /*For shop manager*/
            require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/manage_shop_manager/class-wds-manage_ticket.php';
            $this->ticket_manage_loader_manager = new  WDS_Manager_Manage_Ticket($this->current_user_id, $this->current_user_role);
            
            /*For customer account*/
            if($this->role == "customer" ){
                require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/customer/class-wds-customer.php';
                $this->customer = new  WDS_Customer_Account($this->current_user_id, $this->current_user_role);
            }
        }
         
         /*Admin*/
        function manage_ticket(){ 
            $this->ticket_manage_loader->show();
        }
        function manage_ticket_discussion_admin(){
            $this->ticket_manage_loader->discussion();
        }
        function manage_ticket_merge_ticket(){
            $this->ticket_manage_loader->merge_ticket_show();
        }
        function settings(){
            $this->ticket_manage_loader->settings();
        }
        function emails_ticket(){
            $this->ticket_manage_loader->emails_ticket();
        }
        function canned(){
            $this->ticket_manage_loader_canned->show();
        }
        function canned_create(){
            $this->ticket_manage_loader_canned->create();
        }
        function canned_edit(){
            $this->ticket_manage_loader_canned->edit();
        }
        function canned_delete(){
            $this->ticket_manage_loader_canned->delete();
        }


        /*Shop Manager*/
        function manage_ticket_manager(){
            $this->ticket_manage_loader_manager->show();
        }
        function manage_ticket_discussion(){
            $this->ticket_manage_loader_manager->discussion();
        }
        
        function manage_ticket_history(){
            
            if($this->current_user_role == "administrator"){
                $this->ticket_manage_loader->history_show();
            }else if($this->current_user_role == "ticket_manager"){
                $this->ticket_manage_loader_manager->history_show();
            }
        }
        
        
        function catch_request(){
            if(isset($_POST['assign_ticket_user'])){
                $this->ticket_manage_loader->assign_ticket();
            }
            if(isset($_POST['ticket_create_authorized'])){
                $this->is_customer_authorized($this->current_user_role);
                $this->customer->generate_ticket();
            }
            if(isset($_POST['ticket_create_authorized_customer'])){
                $this->is_customer_authorized($this->current_user_role);
                $this->customer->ticket_reply();
            }
            if(isset($_POST['ticket_close_authorized_customer'])){
                $this->is_customer_authorized($this->current_user_role);
                $this->customer->ticket_close();
            }
            
            if(isset($_POST['ticket_create_authorized_executive'])){
                $this->is_customer_executive($this->current_user_role);
                $this->ticket_manage_loader_manager->ticket_reply();
            }
            if(isset($_POST['ticket_close_authorized_executive'])){
                $this->is_customer_executive($this->current_user_role);
                $this->ticket_manage_loader_manager->ticket_close();
            }
            /*Admin action*/
            if(isset($_POST['ticket_create_authorized_admin'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->ticket_reply();
            }
            if(isset($_POST['ticket_close_authorized_admin'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->ticket_close();
            }
            if(isset($_POST['ticket_priority_authorized_admin'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->priority_update();
            }
            
            if(isset($_POST['ticket_merge_action'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->ticket_merge();
            }
            if(isset($_POST['settings_admin'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader->settings_save();
            }
            if(isset($_POST['canned_new'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader_canned->save();
            }
            if(isset($_POST['canned_edit'])){
                $this->is_admin_authorized($this->current_user_role);
                $this->ticket_manage_loader_canned->edit_save();
            }
            
            
            if(isset($_POST['ticket_reopen'])){
                $this->is_authorized($this->current_user_role);
                $this->ticket_reopen();
            }
           
        }
        
        /*Common Re-open*/
        function ticket_reopen(){    
            global $wpdb;
            $data['status'] =0;
            $table =  $wpdb->prefix."mwpl_tickets"; 
            $update = $this->update_record($table, $data, array('id'=>$_POST['ticket_id']));
            
            
            $ticket_information = $this->get_record_by_id($table, array('id'=>$_POST['ticket_id']));
            
            $to = $this->get_user_field($ticket_information->customer_id,'user_email');   
            $executive_to = $this->get_user_field($ticket_information->staff_id,'user_email');   
            
            
            
            
            if($update){
                
                if($this->current_user_role == "customer"){
                    $this->notfication_ticket_action($executive_to, "Ticket Re-Open - #".$_POST['ticket_id'], "<h3>Ticket has been re-open.</h3>");
                    $this->notice_front('Ticket has been re-open successfully!');
                }else{
                     $this->notfication_ticket_action($to, "Ticket Re-Open - #".$_POST['ticket_id'], "<h3>Ticket has been re-open.</h3>");
                    $this->notice('Ticket has been re-open successfully!');
                }
                
            }else{
                
                if($this->current_user_role == "customer"){
                   
                    $this->notice_front('Please try again!','danger');
                }else{
                    $this->notice('Please try again!','error');
                }
                
            }
        }
        
        /*Customer account short code*/
        function account_customer_load(){ 
            if(is_admin()){
                return false;
            }
            $this->is_customer_authorized($this->current_user_role);
            $this->customer->load_module();
        }
        
        
        /*Canned fetch*/
    function cannedfetchlist(){
        if(isset($_POST['term']) && $_POST['term'] !=""){
           $data = array();
           $result =  $this->get_records_wildcard($this->table_canned, " title LIKE '%".$_POST['term']."%' ");
           if(!empty($result)){
               $cnt=0;
               foreach($result as $r){
                   $data[$cnt]['value'] = $r->title;
                   $data[$cnt]['id'] = $r->id;
                   $cnt++;
               }
               echo json_encode($data); die();
           }
        }
    }
        

}
