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
class MWPL_Administrator  {
    
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
        
        /*Ticket manage ajax*/
        add_action('wp_ajax_tourordermanage',array(&$this,'tourordermanag_show_list'));
        add_action('wp_ajax_nopriv_tourordermanag',array(&$this,'tourordermanag_show_list'));
        
        /*Table name defined*/
        global $wpdb;
        $this->order=$wpdb->prefix."mwpl_tour_order";
        $this->transaction=$wpdb->prefix."mwpl_tour_order_transaction";       
        $this->table_settings = $wpdb->prefix."mwpl_settings";
        $this->order_log=$wpdb->prefix."mwpl_tour_order_log";
        
    }
    
    function show(){  
        $this->load_view_admin('administrator/view/list.php');
    }
    function details(){
        $id = 0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        $record = $this->get_record_by_id($this->order, array('id'=>$id));
        if(empty($record)){
            $this->notice('Invalid order id.Please try again!','danger');
            @wp_redirect(admin_url('admin.php?page=mwpl_order')); 
            return false;
        }
        $content['r'] = $record;
        $content['trans'] = $this->get_record_by_id($this->transaction, array('order_id'=>$id,'status'=>'Paid'));
        $content['status'] = $this->get_records($this->order_log, array('order_id'=>$id),array('id DESC'));
        $content['call'] = $this;
        $this->load_view_admin('administrator/view/details.php',$content);
    }
    function tourordermanag_show_list(){ 
        $aColumns = array("id", "title", "tour","transaction","","");
        $condition=array();
        
        if($_POST['order_search'] !=""){
            $condition[]="id =  ".$_POST['order_search'];
        }       
        if(!empty($condition)){
            $condition = implode(" AND ", $condition);
        }
       
        if(!empty($condition)){           
            $info = $this->set_data_table_condition($aColumns,$condition);
        }else{ 
            $info = $this->set_data_table($aColumns);
        }
        
        $details = $this->get_lists_request($info['sLimit'], $onlyCount=false , $info['sOrder'],$info['sWhere']);
        $counts = $this->get_lists_request('', $onlyCount=true , $info['sOrder'],$info['sWhere']);
        $output = array(
                "sEcho" => intval($_REQUEST['sEcho']),
                "iTotalRecords" => count($details),
                "iTotalDisplayRecords" => $counts,
                "aaData" => array()
        ); 
        /*Users list*/        
        $usersAll = $this->get_users_list(['tour_executive']); 
        if(!empty($details)):       
        foreach($details as $k=>$v){  
           
            $transaction='';
            $staff = '';
            if($v['transaction'] == ""){
                $transaction = '<span class="badge badge-danger">Pending</span>';
            }else{
                $transaction = '<span class="badge badge-success">'.$v['transaction'].'</span>';
            }
            
            
            $select='';
            if(!empty($usersAll)){
                $select.="<form method='post' action='' class='mwpl_short_form'>";
                $select.="<select name='assign_order_executive' class='form-control mwpl_form_submit'>";
                $select.="<option value=''>--Choose--</option>";
                foreach($usersAll as $user){
                    $user_exist='';
                    if($this->is_tour_assigned($user->ID, $v['id'])){
                        $user_exist="selected";
                    }
                    $select.="<option value='".$user->ID."'  ".$user_exist.">".$user->display_name."</option>";
                }
                $select.="</select>";
                $select.="<input type='hidden' name='order_id' value='".$v['id']."'>";
                $select.="</form>";
            }
            
            
            $button = '<a href="admin.php?page=mwpl_order_view&id='.$v['id'].'" class="btn btnView">Details</a>';
            $output['aaData'][] = array($v['id'], $v['tour'], $transaction ,$select,$button);        
        }
        endif;
        echo json_encode($output);
        die();
    }    
    function get_lists_request($sLimit, $onlyCount=false ,  $sOrder,$sWhere){
        global $wpdb;
        $table= $this->order;
        if($onlyCount==true){
           $query="SELECT *FROM $table  $sWhere  $sOrder ";               
           $sql=$wpdb->get_results($query);               
           return count($sql);
        }else{
            $query="SELECT *FROM $table  $sWhere  $sOrder $sLimit";   
            $get=$wpdb->get_results($query); 
            if(count($get) > 0){
                $i=0;
                foreach($get as $r){
                     $data[$i]['id']=$r->id;                     
                     $data[$i]['tour']= '<a target="_blank" href="'.get_permalink($r->tour_id).'">'.$this->get_post_field_by_id($r->tour_id).'</a>';    
                     $data[$i]['transaction']=$r->transaction;
                     $data[$i]['staff']=$r->staff_id;
                     $i+=1;  
                }
                return $data;
            }
        }
    }
    function assign_order(){
        /*Insert to new record*/
        global $wpdb;
        /* Ticket assign */
        $order_assign = $wpdb->update( 
            $this->order, 
            array( 
                    'staff_id' => $_POST['assign_order_executive'],
            ),
            array(
                'id'=>$_POST['order_id']
            )
        );
        
        if($order_assign){
            $to = $this->get_user_field($_POST['assign_order_executive'],'user_email');        
            $this->notfication_ticket_action($to, "Order assigned you - #".$_POST['order_id'], "<p>Order has been assigned you. Please check.</p>");
            $this->notice('Order has been assigned successfully!');
        }else{
            $this->notice('Please try again!');
        }
    }
    function is_tour_assigned($executive_manager_id=0,$order_id=0){
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM {$this->order} WHERE staff_id = {$executive_manager_id} AND  id = {$order_id} ");
    }
    function settings(){
        //$this->sendSMTPSystem("harrujasson@yopmail.com", 'Subject', 'Content'); die();
        $content['setting'] = $this->get_record_by_row($this->table_settings, array("type"=>"admin",'service'=>"email"));
        $content['general_setting'] = $this->get_record_by_row($this->table_settings, array("type"=>"admin",'service'=>"general"));
        $this->load_view_admin('administrator/view/setting.php',$content);
    }
    function settings_save(){
        $service = 'email';
        if(isset($_POST['service']) && $_POST['service'] != ""){
            $service = $_POST['service'];
        }
        unset($_POST['settings_admin']);
        unset($_POST['service']);
        
        $save_data = $_POST;
        
        $exist_status = $this->get_record_exist($this->table_settings, array("type"=>"admin",'service'=>$service)) ;
        
        $data['type'] ='admin';
        $data['service'] = $service;
        $data['information'] = json_encode($save_data);
        $data['user_id'] = $this->userid;
        
        if($exist_status){
            $update = $this->update_record($this->table_settings, $data,array("type"=>"admin","service"=>$service));
            if($update){
                $this->notice('Setting has been saved successfully!');
            }else{
                $this->notice('Something went wrong.Please try again!','error');
            }
        }else{
            $insert = $this->insert_record($this->table_settings, $data);
            if($insert){
                $this->notice('Setting has been saved successfully!');
            }else{
                $this->notice('Something went wrong.Please try again!','error');
            }
        }
    }
}
