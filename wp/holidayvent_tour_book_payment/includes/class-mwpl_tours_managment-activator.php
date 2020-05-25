<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */
class Mwpl_tours_managment_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            
            ob_start();
            /*Required tables create*/
            global $wpdb;
            global $database_db_version;
            $tour_order_table_name = $wpdb->prefix . "mwpl_tour_order";                    
            $query_order ="CREATE TABLE IF NOT EXISTS $tour_order_table_name ( id int(11) NOT NULL AUTO_INCREMENT,"
                    . "`customer_id` int(11) NOT NULL,
                        `staff_id` int(11) NOT NULL,
                        `tour_id` int(11) NOT NULL,
                        `title` varchar(55) DEFAULT NULL,                        
                        `description` text,
                        `transaction` text,
                        `number_of_person` int(11) DEFAULT NULL,  
                        `number_of_infant` int(11) DEFAULT NULL,  
                        `date_of_tour` varchar(255) DEFAULT NULL, 
                        `status` tinyint(4) NOT NULL DEFAULT '0', 
                        `tour_price` DOUBLE NOT NULL DEFAULT '0', 
                        `sub_total` DOUBLE NOT NULL DEFAULT '0', 
                        `gst`  DOUBLE NOT NULL DEFAULT '0', 
                        `grand_total` DOUBLE NOT NULL DEFAULT '0', 
                        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,PRIMARY KEY (id))"; 
                    

            $order_tranaction_table_name = $wpdb->prefix . "mwpl_tour_order_transaction";
            $query_order_transaction ="CREATE TABLE IF NOT EXISTS $order_tranaction_table_name ( id int(11) NOT NULL AUTO_INCREMENT,"
                    . "
                        `order_id` int(11) NOT NULL,
                        `status` varchar(255) DEFAULT NULL,  
                        `transaction_id` text,
                        `bank_ref_no` text,                        
                         method  varchar(255) DEFAULT NULL,  
                        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,PRIMARY KEY (id))";  
            
            $settings_table_name = $wpdb->prefix . "mwpl_settings";
            $query_settings ="CREATE TABLE IF NOT EXISTS $settings_table_name ( id int(11) NOT NULL AUTO_INCREMENT,"
                    . "`type` varchar(255) DEFAULT NULL,
                    `service` varchar(255) DEFAULT NULL,
                    `information` text NOT NULL,
                    `user_id` int(11) NOT NULL,
                    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,PRIMARY KEY (id))";
            
            $order_order_log_table_name = $wpdb->prefix . "mwpl_tour_order_log";
            $query_order_order_log ="CREATE TABLE IF NOT EXISTS $order_order_log_table_name ( id int(11) NOT NULL AUTO_INCREMENT,"
                    . "`order_id` int(11) NOT NULL,
                        updated_by int(11) NOT NULL,
                        `status` varchar(255) DEFAULT NULL,  
                        `comment` text,                        
                        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,PRIMARY KEY (id))";  
           
            
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $wpdb->query($query_order);
            $wpdb->query($query_order_transaction);
            $wpdb->query($query_settings);
            $wpdb->query($query_order_order_log);
            add_option("database_db_version", $database_db_version);
            /*End Required tables create*/
          
            
            
            /*Generate the manager role*/
            if(self::role_exists('tour_executive') ==  false){
                
                add_role( 'tour_executive', 'Tour Executive',  array(
                    'read' => true, // true allows this capability
                    'edit_posts' => true, // Allows user to edit their own posts                  
                ));
            }
            
            if(self::role_exists('customer') ==  false){
                
                add_role( 'customer', 'Customer',  array(
                    'read' => true, // true allows this capability
                    'edit_posts' => false, // Allows user to edit their own posts
                    'edit_pages' => false, // Allows user to edit pages
                ));
            }
            
            /*Generate the customer page*/
            $check_page_exist = get_page_by_title('Customer Account', 'OBJECT', 'page');
            if(empty($check_page_exist)) {
                $page_id = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Customer Account'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Customer Account'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-account-dashboard]',
                    'post_type'      => 'page'
                    )
                );
                if($page_id){
                    update_post_meta( $page_id, '_wp_page_template', 'customer-dashboard.php' );
                }
            }
            
            /*Customer Account Login*/
            $check_page_login_customer_exist = get_page_by_title('Customer Account Login', 'OBJECT', 'page');
            if(empty($check_page_login_customer_exist)) {
                $page_id_2 = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Customer Account Login'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Customer Account Login'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-account-login]',
                    'post_type'      => 'page'
                    )
                );
                if($page_id_2){
                    update_post_meta( $page_id_2, '_wp_page_template', 'customer-account-login.php' );
                }
            }
            
            /*Customer Account Login*/
            $check_page_register_customer_exist = get_page_by_title('Customer Account Register', 'OBJECT', 'page');
            if(empty($check_page_register_customer_exist)) {
                $page_id_3 = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Customer Account Register'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Customer Account Register'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-account-register]',
                    'post_type'      => 'page'
                    )
                );
                if($page_id_3){
                    update_post_meta( $page_id_3, '_wp_page_template', 'customer-account-register.php' );
                }
            }
           
            $check_page_exist_guest_user = get_page_by_title('Guest Account', 'OBJECT', 'page');
            if(empty($check_page_exist_guest_user)) {
                $page_id_4 = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Guest Account'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Guest Account'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-guest-account]',
                    'post_type'      => 'page'
                    )
                );  
                if($page_id_4){
                    update_post_meta( $page_id_4, '_wp_page_template', 'customer-account-fullpage.php' );
                }
            }
            
            
            $check_page_exist_tour_payment = get_page_by_title('Tour Payment', 'OBJECT', 'page');
            if(empty($check_page_exist_tour_payment)) {
                $page_id_5 = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Tour Payment'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Tour Payment'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-tour-payment]',
                    'post_type'      => 'page'
                    )
                );   
                if($page_id_5){
                    update_post_meta( $page_id_5, '_wp_page_template', 'customer-account-fullpage.php' );
                }
            }
            
            $check_page_exist_payment_account = get_page_by_title('Payment Response', 'OBJECT', 'page');
            if(empty($check_page_exist_payment_account)) {
                $page_id_6 = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Payment Response'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Payment Response'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-payment-response]',
                    'post_type'      => 'page'
                    )
                );  
                if($page_id_6){
                    update_post_meta( $page_id_6, '_wp_page_template', 'customer-account-fullpage.php' );
                }
            }
            $check_page_exist_payment_account_cancel = get_page_by_title('Payment Cancel', 'OBJECT', 'page');
            if(empty($check_page_exist_payment_account_cancel)) {
                $page_id_7 = wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords('Payment Cancel'),
                    'post_name'      => strtolower(str_replace(' ', '-', trim('Payment Cancel'))),
                    'post_status'    => 'publish',
                    'post_content'   => '[mwpl-customer-payment-cancel]',
                    'post_type'      => 'page'
                    )
                );  
                if($page_id_7){
                    update_post_meta( $page_id_7, '_wp_page_template', 'customer-account-fullpage.php' );
                }
            }           
            /*End Generate the customer page*/
            
            
            flush_rewrite_rules();
    }
    
    static function  role_exists( $role ) {

        if( ! empty( $role ) ) {
          return $GLOBALS['wp_roles']->is_role( $role );
        }
        return false;
    }

}
