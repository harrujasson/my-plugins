<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webdesign-studenten.nl/
 * @since      1.0.0
 *
 * @package    Wds
 * @subpackage Wds/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wds
 * @subpackage Wds/public
 * @author     Webdesign studenten <info@webdesign-studenten.nl>
 */
class Wds_Public {
        use WDS_Common;
        use WDS_Roles;
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
        private $table_ticket ='';
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                add_action( 'template_include', array($this,'customer_front_template_set') );
                
                /*Catch request public*/
                $this->catch_request_public();
                /*Guest Ticket Form*/
                add_shortcode( 'wds-guest-ticket-form', array(&$this,'guest_ticket_form') );
                
                
                
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wds-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wds-public.js', array( 'jquery' ), $this->version, false );

	}
        function customer_front_template_set( $template ) {
            $plugindir = dirname( __FILE__ );
            if ( is_page_template( 'customer-dashboard.php' )) {       
                $template = $plugindir . '/templates/customer-dashboard.php';
            }
            return $template;
        }
        
        function catch_request_public(){
            if(isset($_POST['ticket_create_guest'])){
                $this->ticket_generate();
            }
        }
        function guest_ticket_form(){
            
            $this->load_view('partials/guest/form.php');
        }
        function ticket_generate(){
            global $wpdb;
            $this->table_ticket=$wpdb->prefix."mwpl_tickets";
            if($_POST['first_name'] ==""){
                $this->notice_front('First Name field is required','danger');
                return false;
            }
            if($_POST['last_name'] ==""){
                $this->notice_front('Last Name field is required','danger');
                return false;
            }
            if($_POST['email'] ==""){
                $this->notice_front('Email field is required','danger');
                return false;
            }
            if($_POST['subject'] ==""){
                $this->notice_front('Subject field is required','danger');
                return false;
            }
            $customer_id =0;
            $new_user=0;
            $user = $this->get_user_by_info('email',$_POST['email']);

            if(!empty($user)){           
                if(isset($user->first_name)){
                    $data['first_name'] = $user->first_name;
                }
                if(isset($user->last_name)){
                    $data['last_name'] = $user->last_name;
                }
                if(isset($user->user_email)){
                    $data['email'] = $user->user_email;
                }
                if(isset($user->billing_phone)){
                    $data['telephone'] = $user->billing_phone;
                }
                $customer_id= $user->ID;
            }else{
                if(email_exists($_POST['email'])){
                    $this->notice_front('This email already exist. Please try with other email','danger');
                    return false;
                }
                $customer_id = $this->create_customer_user($_POST['first_name'].'-'.$_POST['last_name'], $_POST['email'],$_POST['first_name'],$_POST['last_name'],$_POST['telephone']);
                $data['first_name'] = $_POST['first_name'];
                $data['last_name'] = $_POST['last_name'];
                $data['email'] = $_POST['email'];
                $data['telephone'] = $_POST['telephone'];
                if(!$customer_id){
                    $this->notice_front('New user create problem. Please try after some time','danger');
                    return false;
                }
                $new_user=1;
            }
           
            $data['attachment'] = $this->upload_file();
            $data['subject'] = $_POST['subject'];
            $data['category'] = $_POST['category'];
            $data['description'] = $_POST['description'];
            $data['customer_id'] = $customer_id;

            $insert = $this->insert_record($this->table_ticket,$data,1);     
            $subject= "New Ticket Generate #".$insert;
            if($insert){
                $this->notfication_ticket_action($data['email'], "New Ticket Generate #".$insert, "<p>Your ticket has been generated successfully!</p>");
                if($new_user){
                    $this->notice_front('Ticket has been generated successfully!, Please check you email, username and password has been send on registered email for login dashboard pannel.');
                }else{
                    $this->notice_front('Ticket has been generated successfully!, Please login your dashboard and track your ticket.');
                }
                
            }else{
                $this->notice_front('Please try again!','danger');
            }
        }
       
       
}
