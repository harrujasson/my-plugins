<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */

trait MWPL_Roles{
   
    private $role;
    private $user_id;
    
    function set_user_role(){      
       if(!function_exists('wp_get_current_user')) {
            include(ABSPATH . "wp-includes/pluggable.php"); 
        }
        $user_information = wp_get_current_user();         
        if(!empty($user_information)){
            if(!empty($user_information->roles)){
                $this->role = $user_information->roles[0];
            }
            $this->user_id = $user_information->ID;
        }
    }
    function get_user_role_information($key='role'){
        return $this->$key;
    }
    function is_store_manager(){
        $role = $this->get_user_role_information();
        return $role;
    }
   
    function get_users_list($type=array('Customer'),$search=''){
        $args = array(
            'role__in'     => $type,
            'meta_compare' => '',            
            'orderby'      => 'nicename',
            'order'        => 'ASC',
            'search'       => $search,
            'fields'       => 'all',
            'who'          => '',
        ); 
       
        $users = get_users($args);
        return $users;
    }
    function get_user_by_id($id=0){
        return get_userdata($id);
    }
    function get_user_by_info($field='id',$value=''){
        return get_user_by( $field,$value );
    }
    function get_user_field($id=0,$field='display_name'){
      $user =   get_userdata($id);
      //echo "<pre>"; print_r($user); echo "</pre>"; die();
      if(!empty($user)){
          if(isset($user->$field)){
              return $user->$field;
          }
      }
    }
    function get_user_role($id=0){
        $user =   get_userdata($id);
        if(!empty($user)){
            $role = $user->roles[0];
            switch ($role){
                case "tour_executive":
                    return "Executive";
                    break;
                case "administrator":
                    return "Admin";
                    break;
                case "customer":
                    return "Customer";
                    break;
                default :
                    return $role;
                    
            }
        }
    }
    
}
?>