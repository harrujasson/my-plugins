<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/public
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */
class Mwpl_tours_managment_Public {

        use MWPL_Common;
        use MWPL_Roles;
        use MPWL_Authorized;
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
        private $current_user_role;
        private $current_user_id;
        private $order ='';
        private $transaction ='';
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                
                /*Set current user role*/
                $this->set_user_role();
                $this->current_user_role = $this->get_user_role_information('role');
                $this->current_user_id = $this->get_user_role_information('user_id');
                
                /*Templates Load for customer account*/
                add_action( 'template_include', array($this,'customer_front_template_set') );
                
                /*Shortcodes Load*/
                add_shortcode( 'mwpl-customer-account-login', array(&$this,'customer_login') );
                add_shortcode( 'mwpl-customer-account-register', array(&$this,'customer_register') );
                add_shortcode( 'mwpl-customer-guest-account', array(&$this,'customer_guest') );
                
                /*Tour Payment page*/
                add_shortcode( 'mwpl-customer-tour-payment', array(&$this,'tour_payment') );
                
                /*CCAvenue payment status*/
                add_shortcode( 'mwpl-customer-payment-response', array(&$this,'payment_response') );
                add_shortcode( 'mwpl-customer-payment-cancel', array(&$this,'payment_cancel') );
                
                
                
                /*Tour price get via ajax*/
                add_action('wp_ajax_tourprice',array(&$this,'get_tourprice'));
                add_action('wp_ajax_nopriv_tourprice',array(&$this,'get_tourprice'));
                
                /*Catch request public*/
                $this->catch_request_public();
                
                /*Table name defined*/
                global $wpdb;
                $this->order=$wpdb->prefix."mwpl_tour_order";
                $this->transaction=$wpdb->prefix."mwpl_tour_order_transaction"; 

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
		 * defined in Mwpl_tours_managment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwpl_tours_managment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwpl_tours_managment-public.css', array(), $this->version, 'all' );

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
		 * defined in Mwpl_tours_managment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwpl_tours_managment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mwpl_tours_managment-public.js', array( 'jquery' ), $this->version, false );

	}
        
        /*Templates load*/
        function customer_front_template_set( $template ) {
            $plugindir = dirname( __FILE__ );
            if ( is_page_template( 'customer-dashboard.php' )) {       
                $template = $plugindir . '/templates/customer-dashboard.php';
            }elseif(is_page_template( 'customer-account-register.php' )){
                $template = $plugindir . '/templates/customer-account-register.php';
            }elseif(is_page_template( 'customer-account-login.php' )){
                $template = $plugindir . '/templates/customer-account-login.php';
            }elseif(is_page_template( 'customer-account-fullpage.php' )){               
                $template = $plugindir . '/templates/customer-fullpage.php';
            }
            
            return $template;
        }
        
        function customer_login(){          
            $this->redirect($this->current_user_role);
            $this->load_view('partials/customer/login.php');
        }
        function customer_register(){
            $this->redirect($this->current_user_role);
            $this->load_view('partials/customer/register.php');
        }
        
        function catch_request_public(){
            if(isset($_POST['customer_register'])){
                $this->customer_register_create();
            }
            if(isset($_POST['customer_login'])){
                $this->customer_login_action();
            }
            if(isset($_POST['customer_tour_book'])){
                $this->customer_tour_create();
            }
            if(isset($_POST['customer_tour_book_guest'])){
                $this->customer_tour_create_guest();
            }
        }
        function customer_register_create(){
            global $wpdb;            
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
            
            if(email_exists($_POST['email'])){
                $this->notice_front('This email already exist. Please try with other email','danger');
                return false;
            }
            $customer_id =0;
            
            $other_information['billing_city'] = $_POST['billing_city'];
            $other_information['billing_address_1'] = $_POST['billing_address_1'];
            $other_information['billing_state'] = $_POST['billing_state'];
            $other_information['billing_country'] = $_POST['billing_country'];
            $other_information['billing_postcode'] = $_POST['billing_postcode'];              
            $user = $this->get_user_by_info('email',$_POST['email']);            
            
            $insert = $this->create_customer_user($_POST['first_name'].'-'.$_POST['last_name'], $_POST['email'],$_POST['first_name'],$_POST['last_name'],$_POST['telephone'],$other_information);            
            if($insert){
                 $this->notice_front('Your account has been registered successfully!, Please check you registered email "Username" and "Password" has been sent on registered email for login dashboard pannel.');                
            }else{
                $this->notice_front('Please try again!','danger');
            }
        }
        function customer_login_action(){
            if($_POST['username'] ==""){
                $this->notice_front('User Name field is required','danger');
                return false;
            }
            if($_POST['password'] ==""){
                $this->notice_front('Password field is required','danger');
                return false;
            }
            $credentials['user_login'] = $_POST['username'];
            $credentials['user_password'] = $_POST['password'];
            $credentials['remember'] = true;
            $user = wp_signon( $credentials, false );
            if ( is_wp_error($user) ){
              $this->notice_front($user->get_error_message(),'danger');
              return FALSE;  
            }else{
                @wp_redirect(site_url('customer-account'));
                die();
            }
        }
        function customer_guest(){
            
           
            if(!isset($_GET['tour_id']) || $_GET['tour_id'] ==""){
                $this->notice_front("Invalid Request URL",'danger');
                @wp_redirect(site_url('customer-account-login'));
                die();
            }  
            $page_node_1 = $_GET['tour_id'];
            $package_name = get_the_title($page_node_1);
            
            $package_price = $this->getMetavalue($page_node_1, "cmsmasters_project_price");
            $data['package_name'] = $package_name;
            $data['package_price'] = $package_price; 
            $data['tour_id'] = $page_node_1;    
            $this->load_view('partials/payment/guest_form.php',$data);
        }
        
        function tour_payment(){
//            global $wp_query;
//            echo "<pre>"; print_r($wp_query->query_vars); echo "</pre>"; die();
            $page_node_1='';            
            $package_name = "";
            $package_price = 0;
            
            if( false !== get_query_var( 'node_first' ) ){            
                $page_node_1 = get_query_var( 'node_first' );
            }            
            if($page_node_1 == ""){
                $this->notice_front("Invalid Request URL",'danger');
                @wp_redirect(site_url('customer-account-login'));
                die();
            }
            
            /*Checking customer login or not*/
           
            if($this->current_user_role != "customer"){
                @wp_redirect(site_url('guest-account?tour_id='.$page_node_1));
                die();
            }
            $this->is_customer_authorized($this->current_user_role);
            
            $package_price = $this->getMetavalue($page_node_1, "cmsmasters_project_price");
            $package_name = get_the_title($page_node_1);
          
            $data['package_name'] = $package_name;
            $data['package_price'] = $package_price;   
            $data['tour_id'] = $page_node_1;
            $this->load_view('partials/payment/form.php',$data);
        }
        
        function get_tourprice(){
           $price =  $this->getMetavalue($_POST['tour_id'], "cmsmasters_project_price");
           echo $price; die();
        }
        function customer_tour_create_guest(){
            global $wpdb;
            $this->order=$wpdb->prefix."mwpl_tour_order";
            if(!isset($_POST['tour_id']) || $_POST['tour_id'] ==""){
                $this->notice_front("Invalid Request URL",'danger');
                @wp_redirect(site_url('customer-account-login'));
            }
            /*Customer new create*/
            global $wpdb;            
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
            
            if(email_exists($_POST['email'])){
                $this->notice_front('This email already exist. Please try with other email','danger');
                return false;
            }
            
            $other_information['billing_city'] = $_POST['billing_city'];
            $other_information['billing_address_1'] = $_POST['billing_address_1'];
            $other_information['billing_state'] = $_POST['billing_state'];
            $other_information['billing_country'] = $_POST['billing_country'];
            $other_information['billing_postcode'] = $_POST['billing_postcode'];            
            $user = $this->get_user_by_info('email',$_POST['email']);            
            
            $customer_id = $this->create_customer_user($_POST['first_name'].'-'.$_POST['last_name'], $_POST['email'],$_POST['first_name'],$_POST['last_name'],$_POST['telephone'],$other_information);            
            $this->user_id = $customer_id;
            if ( !is_wp_error( $user ) ){
            
                wp_clear_auth_cookie();
                wp_set_current_user ( $customer_id );
                wp_set_auth_cookie  ( $customer_id);
            }
            
            
            $package_price = $this->getMetavalue($_POST['tour_id'], "cmsmasters_project_price");
            $price_information = $this->tour_price_set($package_price, $_POST['number_of_person'], $_POST['number_of_infant']);
            
            $data['customer_id']= $customer_id;
            $data['tour_id'] = $_POST['tour_id'];
            $data['title'] = get_the_title($_POST['tour_id']);
            $data['tour_id'] = $_POST['tour_id'];
            $data['description'] = $_POST['description'];
            $data['number_of_person'] = $_POST['number_of_person'];
            $data['number_of_infant'] = $_POST['number_of_infant'];
            $data['date_of_tour'] = date('Y-m-d', strtotime($_POST['date_of_tour'])) ;
            $data['tour_price'] = $package_price;
            $data['sub_total'] = $price_information['subtotal'];
            $data['gst'] = $price_information['gst'];
            $data['grand_total'] = $price_information['grand_total'];
            
           
            $insert = $this->insert_record($this->order, $data,1);
            if($insert){
                $this->payment_process($insert,$price_information['grand_total']); 
            }else{
                $this->notice_front("Something went wrong. Please try after some time.",'danger');
            }
            
            
        }
        function payment_process($order_id=0,$amount=0){
            $payment =new MWPL_Ccavenue($this->user_id);
            $response = $payment->set_fields($order_id, $amount);            
        }
        function customer_tour_create(){
            global $wpdb;
            $this->order=$wpdb->prefix."mwpl_tour_order";
            if(!isset($_POST['tour_id']) || $_POST['tour_id'] ==""){
                $this->notice_front("Invalid Request URL",'danger');
                @wp_redirect(site_url('customer-account-login'));
            }
            
            $package_price = $this->getMetavalue($_POST['tour_id'], "cmsmasters_project_price");
            $price_information = $this->tour_price_set($package_price, $_POST['number_of_person'], $_POST['number_of_infant']);
            
            $data['customer_id']= $this->current_user_id;
            $data['tour_id'] = $_POST['tour_id'];
            $data['title'] = get_the_title($_POST['tour_id']);
            $data['tour_id'] = $_POST['tour_id'];
            $data['description'] = $_POST['description'];
            $data['number_of_person'] = $_POST['number_of_person'];
            $data['number_of_infant'] = $_POST['number_of_infant'];
            $data['date_of_tour'] = date('Y-m-d', strtotime($_POST['date_of_tour'])) ;
            $data['tour_price'] = $package_price;
            $data['sub_total'] = $price_information['subtotal'];
            $data['gst'] = $price_information['gst'];
            $data['grand_total'] = $price_information['grand_total'];
            
           
            $insert = $this->insert_record($this->order, $data,1);
            if($insert){
                $this->payment_process($insert,$price_information['grand_total']);   
                $this->notice_front("Order has been generated #inst-".$insert);
            }else{
                $this->notice_front("Something went wrong. Please try after some time.",'danger');
            }
        }
        function tour_price_set($cost=0,$adult=1,$infant=0){
            $adult_price=0;
            $infant_price=0;          
            if($adult){
                $adult_price = $cost * $adult;                
            }
            if($infant){
                $infant_price = $infant * ($cost/2);
            }
            
            $subtotal = $adult_price+$infant_price;
            $gst = $subtotal * 18 /100;
            $grand_total = $subtotal + $gst;
            $data['subtotal'] = $subtotal;
            $data['gst'] = $gst;
            $data['grand_total'] = $grand_total;
            return $data;
        }
        function payment_response(){
           $payment =new MWPL_Ccavenue($this->user_id);
           $response = $payment->response_get();
           
           $data = array();
           $data_update = array();
           $parseData['code'] = $response['code'];
           $parseData['message'] = $response['message'];
           $order_id=0;
           $transaction_id = 0;
           if(!empty($response)){
               if($response['code'] == "1"){
                  $data['status'] ='Paid';
                  foreach($response['response'] as $value){
                      foreach($value as $key=>$v){                        
                        if($key == "order_id"){
                            $order_id = $v;
                            $data['order_id'] = $v;
                        }
                        if($key == "tracking_id"){
                            $data['transaction_id'] = $v;
                            $data_update['transaction'] = $v;
                            $transaction_id = $v;
                        }
                        if($key == "bank_ref_no"){
                            $data['bank_ref_no'] = $v;
                        }
                        if($key=="payment_mode"){
                            $data['method'] = $v;
                        }
                      }
                      
                  }
                  
                  global $wpdb;
                  $order_table=$wpdb->prefix."mwpl_tour_order";
                  $transaction_table = $wpdb->prefix."mwpl_tour_order_transaction";
                  /*Update order details*/
                  $this->update_record($order_table, $data_update, array('id'=>$order_id));
                  
                  /*Create transaction*/
                  $this->insert_record($transaction_table, $data);
               }
           }
           $parseData['transaction']=$transaction_id;
           $this->load_view('partials/payment/status.php',$parseData);
           //echo "<pre>"; print_r($data); print_r($response); echo "</pre>"; die();
        }
        function payment_cancel(){
            $this->load_view('partials/payment/cancel.php');
        }
}
