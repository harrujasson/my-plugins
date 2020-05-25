<?php
ob_start();
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webdesign-studenten.nl/
 * @since      1.0.0
 *
 * @package    Wds
 * @subpackage Wds/middleware
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wds
 * @subpackage Wds/middleware
 * @author     Webdesign studenten <info@webdesign-studenten.nl>
 */
trait MPWL_Authorized {
    
        function is_authorized($role=''){
            if($role == ""){
                @wp_redirect(site_url('/'));
                die();
            }
        }
        function is_authorized_administator($role=''){           
            if($role=="" || $role=="customer"){                  
                @wp_redirect(site_url('wp-login.php'));
                die();
            }
        }
        function is_customer_authorized($role=''){ 
            if($role!="customer"){                
                @wp_redirect(site_url('customer-account-login'));
                die();
            }
        }
        function is_customer_executive($role=''){ 
            if($role!="tour_executive"){                
                @wp_redirect(site_url('wp-login.php'));
                die();
            }
        }
        function is_admin_authorized($role=''){ 
            if($role!="administrator"){                
                @wp_redirect(site_url('wp-login.php'));
                die();
            }
        }
        
        function redirect($role=''){
            switch ($role) {
                case "administrator":
                    @wp_redirect( admin_url('admin.php?page=mwpl_order'));
                    die();
                    break;
                case "tour_executive":
                    @wp_redirect(admin_url('admin.php?page=mwpl_order_executive'));
                    die();
                    break;
                case "customer":
                    @wp_redirect(site_url('customer-account'));
                    die();
                    break;
                default:
                    return false;
                    break;
            }
        }
}
?>



