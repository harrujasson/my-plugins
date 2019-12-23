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
class WDS_Manager_Manage_Ticket  {
    
    use WDS_Common;
    use WDS_Roles;
    
    private $role;
    private $userid;
    private $table_ticket ='';
    private $table_ticket_assign ='';
    private $table_comments ='';
    private $table_canned='';
    
    public function __construct($user_id, $role) {
        $this->role = $role;
        $this->userid =  $user_id;
        
        /*Ticket manage ajax*/
        add_action('wp_ajax_ticketmanagemanager',array(&$this,'ticketmanage_show_list'));
        add_action('wp_ajax_nopriv_ticketmanagemanager',array(&$this,'ticketmanage_show_list'));
        
        /*Ticket History manage ajax*/
        add_action('wp_ajax_ticketmanagehistory_executive',array(&$this,'ticketmanage_history_show_list'));
        add_action('wp_ajax_nopriv_ticketmanagehistory_executive',array(&$this,'ticketmanage_history_show_list'));
        
        
        
        /*Table name defined*/
        global $wpdb;
        $this->table_ticket=$wpdb->prefix."mwpl_tickets";
        $this->table_ticket_assign=$wpdb->prefix."mwpl_ticket_assigned";
        $this->table_comments = $wpdb->prefix."mwpl_tickets_comments";
        $this->table_canned = $wpdb->prefix."mwpl_canned";
    }

    function show(){ 
        $this->load_view_admin('manage_shop_manager/view/list.php');
    }
    function discussion(){   
        $id = 0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        $record = $this->get_record_by_id($this->table_ticket, array('staff_id'=> $this->userid,'id'=>$id));
        if(empty($record)){
            $this->notice('Invalid ticket id.Please try again!','danger');
            @wp_redirect(admin_url('admin.php?page=mwpl_ticket_customer')); 
            return false;
        }
       
        $discussion =  $this->get_records($this->table_comments, array('ticket_id'=> $id));
       
        $content['r'] = $record;
        $content['user'] = $this->get_user_by_id($record->customer_id);
        $content['discussion'] = $discussion;
        $content['call'] = $this;
        
        $this->load_view_admin('manage_shop_manager/view/discussion.php',$content);
    }
    
    function user_id(){
        return $this->userid;
    }
    
    function ticket_reply(){
        
        if($_POST['ticket'] ==""){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        if($_POST['comment'] ==""){
            $this->notice('Reply field required','error');
            return false;
        } 
        $ticket_belong_securiety_check = $this->get_record_exist($this->table_ticket, array('staff_id'=> $this->userid,'id'=>$_POST['ticket'])) ;
        if(!$ticket_belong_securiety_check){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        $ticket_information = $this->get_record_by_id($this->table_ticket, array('staff_id'=> $this->userid,'id'=>$_POST['ticket']));
        
        
        
        
        $data['ticket_id'] = $_POST['ticket'];
        $data['from_id'] = $this->userid;
        $data['to_id'] = $ticket_information->customer_id;
        $data['comment'] = $_POST['comment'];
        $data['attachment'] = $this->upload_file();
        
        $insert = $this->insert_record($this->table_comments, $data);
        if($insert){
            $to = $this->get_user_field($ticket_information->customer_id,'user_email');        
            $this->notfication_ticket_action($to, "Ticket new comment - #".$_POST['ticket'], "<h3>New Message.</h3><p>".$_POST['comment']."</p>");
            $this->notice('Reply posted successfully!');
        }else{
            $this->notice('Please try again!','error');
        }
    }
    function ticket_close(){
        
        if($_POST['ticket'] ==""){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        $ticket_belong_securiety_check = $this->get_record_exist($this->table_ticket, array('staff_id'=> $this->userid,'id'=>$_POST['ticket'])) ;
        if(!$ticket_belong_securiety_check){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        $data['status'] =1;
        $update = $this->update_record($this->table_ticket, $data, array('staff_id'=> $this->userid,'id'=>$_POST['ticket']));
        if($update){
            
            
            $ticket_information = $this->get_record_by_id($this->table_ticket, array('id'=>$_POST['ticket']));
            $to = $this->get_user_field($ticket_information->customer_id,'user_email'); 
            $this->notfication_ticket_action($to, "Ticket Closed - #".$_POST['ticket'], "<h3>Ticket has been closed.</h3>");
            
            
            $this->notice('Ticket has been closed successfully!');
        }else{
            $this->notice('Please try again!','error');
        }
    }
    function ticketmanage_show_list(){ 
        $aColumns = array("id", "last_name", "email","subject","category","status","");
        $condition=array();
        $condition[] =' staff_id =  '.$this->userid;
        if($_POST['email_search'] !=""){
            $condition[]=" email LIKE '%".$_POST['email_search']."%' ";
        }
        if($_POST['last_name'] !=""){
            $condition[]=" last_name LIKE '%".$_POST['last_name']."%' ";
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
        $usersAll = $this->get_users_list(['shop_manager']);  
        if(!empty($details)):       
        foreach($details as $k=>$v){  
            $status='<span class="btn btn-primary">Open</span>';
            if($v['status'] == "1"){
                $status = '<span class="btn btn-primary ticket-close">Close</span>';
            }
            $button = '<a href="admin.php?page=mwpl_ticket_customer_discussion&id='.$v['id'].'">Discussion</a>';
            $output['aaData'][] = array($v['id'], $v['last_name'],  $v['email'], $v['subject'],$v['category'] ,$status ,$button);        
        }
        endif;
        echo json_encode($output);
        die();
    }    
    function get_lists_request($sLimit, $onlyCount=false ,  $sOrder,$sWhere){
        global $wpdb;
        $table= $this->table_ticket;
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
                    $data[$i]['first_name']=$r->first_name;
                    $data[$i]['last_name']=$r->last_name;    
                    $data[$i]['email']=$r->email;
                    $data[$i]['subject']=$r->subject;                                                      
                    $data[$i]['status']=$r->status;    
                    $data[$i]['category']=$r->category;
                    $i+=1;  
               }
               return $data;
           }
        }
    }
    
    
    /*History*/
    function history_show(){
        $this->load_view_admin('manage_shop_manager/view/history/list.php');
    }
    
    function ticketmanage_history_show_list(){ 
        $aColumns = array("id", "last_name", "email","subject","category","status","","");
        $condition=array();
        $condition[] =' staff_id =  '.$this->userid;
        if($_POST['email_search'] !=""){
            $condition[]=" email LIKE '%".$_POST['email_search']."%' ";
        }
        if($_POST['last_name'] !=""){
            $condition[]=" last_name LIKE '%".$_POST['last_name']."%' ";
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
        $usersAll = $this->get_users_list(['ticket_manager']);  
        if(!empty($details)):       
        foreach($details as $k=>$v){  
            
            $status='<span class="btn btn-primary">Open</span>';
            if($v['status'] == "1"){
                $status = '<span class="btn btn-primary ticket-close">Close</span>';
            }
            
            $select='';
            if($v['status'] == "1"){
                $select.="<form method='post' action='' class='mwpl_short_form'>";
                $select.="<select name='ticket_reopen' class='form-control mwpl_form_submit'>";
                $select.="<option value=''>--Choose--</option>";
                $select.="<option value='0'>Re-open</option>";
                $select.="</select>";
                $select.="<input type='hidden' name='ticket_id' value='".$v['id']."'>";
                $select.="</form>";
            }
            $button = '<a href="admin.php?page=mwpl_ticket_customer_discussion&id='.$v['id'].'">Discussion</a>';
            $output['aaData'][] = array($v['id'], $v['last_name'],  $v['email'], $v['subject'] ,$v['category'],$status ,$select,$button);        
        }
        endif;
        echo json_encode($output);
        die();
    }  
    
    
}
