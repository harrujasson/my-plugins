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
class MWPL_Common_Authorized  {
    
    use MWPL_Common;
    use MWPL_Roles;
    
    private $role;
    private $userid;
    private $order ='';
    private $transaction ='';
    private $table_settings ='';
    private $order_log='';
    
    public function __construct($user_id, $role) {
        $this->role = $role;
        $this->userid =  $user_id;
        
        /*Table name defined*/
        global $wpdb;
        $this->order=$wpdb->prefix."mwpl_tour_order";
        $this->transaction=$wpdb->prefix."mwpl_tour_order_transaction";       
        $this->table_settings = $wpdb->prefix."mwpl_settings";
        $this->order_log=$wpdb->prefix."mwpl_tour_order_log";
    }
    function order_upate(){
        if($_POST['order_id'] == ""){
            $this->notice('Invalid order id.Please try again!','danger');
            return false;
        }
        /*Update log*/
        $update = $this->update_record($this->order, array('status'=>$_POST['order_status']), array('id'=>$_POST['order_id']));
        
        /*Insert the log*/
        $this->insert_record($this->order_log, array( 'order_id'=>$_POST['order_id'], 'status'=>$_POST['order_status'],'comment'=>$_POST['comment'],'updated_by'=> $this->userid));
        if($update){
            $this->notice("Order status has been updated ");
        }else{
            $this->notice("Something went wrong. Please try after some time.",'danger');
        }
    }
}
