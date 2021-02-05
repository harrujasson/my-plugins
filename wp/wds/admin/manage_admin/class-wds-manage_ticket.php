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
class WDS_Admin_Manage_Ticket  {
    
    use WDS_Common;
    use WDS_Roles;
    
    private $role;
    private $userid;
    private $table_ticket ='';
    private $table_ticket_assign ='';
    private $table_comments ='';
    private $table_settings ='';
    
    
    public function __construct($user_id, $role) {
        $this->role = $role;
        $this->userid =  $user_id;
        
        /*Ticket manage ajax*/
        add_action('wp_ajax_ticketmanage',array(&$this,'ticketmanage_show_list'));
        add_action('wp_ajax_nopriv_ticketmanage',array(&$this,'ticketmanage_show_list'));
        
        /*Ticket History manage ajax*/
        add_action('wp_ajax_ticketmanagehistory',array(&$this,'ticketmanage_history_show_list'));
        add_action('wp_ajax_nopriv_ticketmanagehistory',array(&$this,'ticketmanage_history_show_list'));
        
       /*Ticket Merge - Tickets list*/
        add_action('wp_ajax_usersticket',array(&$this,'usersticket_tickets'));
        add_action('wp_ajax_nopriv_usersticket',array(&$this,'usersticket_tickets'));
        
        /*Table name defined*/
        global $wpdb;
        $this->table_ticket=$wpdb->prefix."mwpl_tickets";
        $this->table_ticket_assign=$wpdb->prefix."mwpl_ticket_assigned";
        $this->table_comments = $wpdb->prefix."mwpl_tickets_comments";
        $this->table_settings = $wpdb->prefix."mwpl_settings";
       
        
        
    }
    
    function show(){  
        $this->load_view_admin('manage_admin/view/list.php');
    }
    function ticketmanage_show_list(){ 
        $aColumns = array("id", "last_name", "email","subject","category","status","","");
        $condition=array();
        
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
            $user_exist='';
            $status='<span class="btn btn-primary">Open</span>';
            if($v['status'] == "1"){
                $status = '<span class="btn btn-primary ticket-close">Close</span>';
            }
            
            $select='';
            if(!empty($usersAll)){
                $select.="<form method='post' action='' class='mwpl_short_form'>";
                $select.="<select name='assign_ticket_user' class='form-control mwpl_form_submit'>";
                $select.="<option value=''>--Choose--</option>";
                foreach($usersAll as $user){
                    $user_exist='';
                    if($this->is_ticket_assigned($user->ID, $v['id'])){
                        $user_exist="selected";
                    }
                    $select.="<option value='".$user->ID."'  ".$user_exist.">".$user->display_name."</option>";
                }
                $select.="</select>";
                $select.="<input type='hidden' name='ticket_id' value='".$v['id']."'>";
                $select.="</form>";
            }
            $button = '<a href="admin.php?page=mwpl_ticket_discussion&id='.$v['id'].'">Discussion</a>';
            
            $output['aaData'][] = array($v['id'], $v['last_name'],  $v['email'], $v['subject'] ,$v['category'],$status ,$select,$button);        
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
                    $data[$i]['category']=$r->category;
                    $data[$i]['last_name']=$r->last_name;    
                    $data[$i]['email']=$r->email;
                    $data[$i]['subject']=$r->subject;                                                      
                    $data[$i]['status']=$r->status;                           
                    $i+=1;  
               }
               return $data;
           }
        }
    }
    function assign_ticket(){
        /*Insert to new record*/
        global $wpdb;
        /* Ticket assign */
        $ticket_assign = $wpdb->update( 
            $this->table_ticket, 
            array( 
                    'staff_id' => $_POST['assign_ticket_user'],
            ),
            array(
                'id'=>$_POST['ticket_id']
            )
        );
        
        /*History of tickets assigned*/
        $status_update = $wpdb->update( 
            $this->table_ticket_assign, 
            array( 
                    'status' => 0,
            ),
            array(
                'ticket_id'=>$_POST['ticket_id']
            )
        );
        
        $insert = $wpdb->insert( 
                $this->table_ticket_assign, 
                array( 
                        'store_manager_id' => $_POST['assign_ticket_user'], 
                        'ticket_id' => $_POST['ticket_id'] 
                )
        );
        /*End History of tickets assigned*/
        
        
       
        if($ticket_assign){
            $to = $this->get_user_field($_POST['assign_ticket_user'],'user_email');        
            $this->notfication_ticket_action($to, "Ticket assigned you - #".$_POST['ticket_id'], "<p>Ticket has been assigned you. Please check.</p>");
            $this->notice('Ticket has been assigned successfully!');
        }else{
            $this->notice('Please try again!');
        }
        
    }
    
    function is_ticket_assigned($store_manager_id=0,$ticket=0){
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_ticket} WHERE staff_id = {$store_manager_id} AND  id = {$ticket} ");
    }
    
    /*Ticket Discussion*/
    function user_id(){
        return $this->userid;
    }
    function discussion(){   
        $id = 0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        $record = $this->get_record_by_id($this->table_ticket, array('id'=>$id));
        if(empty($record)){
            $this->notice('Invalid ticket id.Please try again!','danger');
            @wp_redirect(admin_url('admin.php?page=mwpl_ticket')); 
            return false;
        }
       
        $discussion =  $this->get_records($this->table_comments, array('ticket_id'=> $id));
       
        $content['r'] = $record;
        $content['user'] = $this->get_user_by_id($record->customer_id);
        $content['discussion'] = $discussion;
        $content['call'] = $this;
        
        $this->load_view_admin('manage_admin/view/discussion.php',$content);
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
        $ticket_belong_securiety_check = $this->get_record_exist($this->table_ticket, array('id'=>$_POST['ticket'])) ;
        if(!$ticket_belong_securiety_check){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        $ticket_information = $this->get_record_by_id($this->table_ticket, array('id'=>$_POST['ticket']));
        
        
        $data['ticket_id'] = $_POST['ticket'];
        $data['from_id'] = $this->userid;
        $data['to_id'] = $ticket_information->customer_id;
        $data['comment'] = $_POST['comment'];
        $data['attachment'] = $this->upload_file();
        $data['private_ticket']=0;
        if(isset($_POST['private_note'])){
            $data['private_ticket'] = 1;
        }
       
           
        $insert = $this->insert_record($this->table_comments, $data);
        if($insert){
            
            if($data['private_ticket']){
                $executive_to = $this->get_user_field($ticket_information->staff_id,'user_email');   
                $this->notfication_ticket_action($executive_to, "Ticket - Private note: #".$_POST['ticket'], "<h3>Private Note.</h3><p>".$_POST['comment']."</p>");
            }else{
                $to = $this->get_user_field($ticket_information->customer_id,'user_email');        
                $this->notfication_ticket_action($to, "Ticket new comment - #".$_POST['ticket'], "<h3>New Message.</h3><p>".$_POST['comment']."</p>");
            
            }
            $this->notice('Reply posted successfully!');
        }else{
            $this->notice('Please try again!','error');
        }
    }
    function priority_update(){
        $data['priority'] = $_POST['priority'];
        $this->update_record($this->table_ticket, $data, array('id'=>$_POST['ticket']));
    }
    function ticket_close(){
        if($_POST['ticket'] ==""){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        $ticket_belong_securiety_check = $this->get_record_exist($this->table_ticket, array('id'=>$_POST['ticket'])) ;
        if(!$ticket_belong_securiety_check){
            $this->notice('Invalid request, Please try again!','error');
            return false;
        }
        
        
        $data['status'] =1;
        $update = $this->update_record($this->table_ticket, $data, array('id'=>$_POST['ticket']));
        if($update){
            
            $ticket_information = $this->get_record_by_id($this->table_ticket, array('id'=>$_POST['ticket']));
            
            $to = $this->get_user_field($ticket_information->customer_id,'user_email');   
            $executive_to = $this->get_user_field($ticket_information->staff_id,'user_email');   
            
            $this->notfication_ticket_action($to, "Ticket Closed - #".$_POST['ticket'], "<h3>Ticket has been closed.</h3>");
            $this->notfication_ticket_action($executive_to, "Ticket Closed - #".$_POST['ticket'], "<h3>Ticket has been closed.</h3>");
            
            $this->notice('Ticket has been closed successfully!');
        }else{
            $this->notice('Please try again!','error');
        }
    }
    
    /*Merge Ticket Show*/
    function merge_ticket_show(){
        $content['users_list'] = $this->get_users_list();
        $this->load_view_admin('manage_admin/view/merge_ticket.php',$content);
    }
    /*Ajax return*/
    function usersticket_tickets(){
       global $wpdb;
       $result = $wpdb->get_results("SELECT id,subject,category FROM {$this->table_ticket} WHERE customer_id = {$_POST['id']} AND status=0");
       if(!empty($result)){
           echo json_encode($result);
           die();  
       }
    }
    function ticket_merge(){
        $staff_id=0;
        if($_POST['user'] ==""){
            $this->notice('Please choose atleast one user, Please try again!','error');
            return false;
        }
        if($_POST['from_ticket'] ==""){
            $this->notice('From ticket field is required, Please try again!','error');
            return false;
        }
        if($_POST['to_ticket'] == ""){
            $this->notice('To ticket field is required, Please try again!','error');
            return false;
        }
        if($_POST['from_ticket'] == $_POST['to_ticket'] ){
            $this->notice('From ticket and To ticket should be different, Please try again!','error');
            return false;
        }     
        $staff_id = $this->get_staff_id($_POST['to_ticket']);       
        $action = $this->update_record($this->table_comments, array('ticket_id'=>$_POST['to_ticket']), array('ticket_id'=>$_POST['from_ticket']));
        if($action){
            $this->delete_record($this->table_ticket, array('id'=>$_POST['from_ticket']));
            $this->notice('Ticket has merged successfully!');
        }else{
            $this->notice('Something went wrong.Please try again!','error');
        }
    }
    function get_staff_id($id){
        return  $this->get_record_by_row($this->table_ticket, array("id"=>$id),'staff_id');
        
    }
   
    /*Settings*/
    function settings(){
        //$this->sendSMTPSystem("harrujasson@yopmail.com", 'Subject', 'Content'); die();
        $content['setting'] = $this->get_record_by_row($this->table_settings, array("type"=>"admin",'service'=>"email")) ;
        $content['general_setting'] = $this->get_record_by_row($this->table_settings, array("type"=>"admin",'service'=>"general"));
        $this->load_view_admin('manage_admin/view/setting.php',$content);
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
    
    
    /*History*/
    function history_show(){
        $this->load_view_admin('manage_admin/view/history/list.php');
    }
    function ticketmanage_history_show_list(){ 
        $aColumns = array("id", "last_name", "email","subject","category","status","","");
        $condition=array();
        
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
            $user_exist='';
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
            
            $button = '<a href="admin.php?page=mwpl_ticket_discussion&id='.$v['id'].'">Discussion</a>';
            
            $output['aaData'][] = array($v['id'], $v['last_name'],  $v['email'], $v['subject'] ,$v['category'],$status ,$select,$button);        
        }
        endif;
        echo json_encode($output);
        die();
    }  
    
    /*Canned*/
    function canned_show(){  
        $this->load_view_admin('manage_admin/view/canned/list.php');
    }
    
    /*Via Emails*/
    function emails_ticket(){
        
        $server_details = get_email_settings_all();
        if(empty($server_details)){
            $this->notice('Please add email server details in Ticket->setting->E-Maile Server tab.','error');
            return false;
        }
        if(!isset($server_details->host_imap) || empty($server_details->host_imap) ){
           $this->notice('Please add IMAP Hostname in IMAP Hostname text field  Ticket->setting->E-Maile Server tab.','error');
           return false; 
        }
        if(!isset($server_details->port) || empty($server_details->port)){
           $this->notice('Please add Port number in Port text field Ticket->setting->E-Maile Server tab.','error');
            return false; 
        }
        if(!isset($server_details->username) || empty($server_details->username)){
           $this->notice('Please add username/Email in Username text field Ticket->setting->E-Maile Server tab.','error');
            return false; 
        }
        if(!isset($server_details->password) || empty($server_details->password)){
           $this->notice('Please add password in Password text field Ticket->setting->E-Maile Server tab.','error');
            return false; 
        }
        if(!isset($server_details->security) || empty($server_details->security) || $server_details->security=="tls"){
           $this->notice('Please choose SSL in Security option Ticket->setting->E-Maile Server tab.','error');
           return false; 
        }
       
        $param['host'] ='{'.$server_details->host_imap.':'.$server_details->port.'/'.$server_details->security.'/novalidate-cert}INBOX';
        $param['username'] =$server_details->username;
        $param['password'] =$server_details->password;
       

        $imap = new ImapFetch($param);
        
        if($imap->connect()){
            $emails  =$imap->information();
          
            if(!empty($emails) || $emails != NULL){
                $cnt=0;
                foreach($emails as $email){
                    $customer_email = $email['header']->from[0]->mailbox.'@'.$email['header']->from[0]->host;
                    if($customer_email!=""){
                       $insert_status = $this->email_ticket_generate($customer_email, $email['subject'], $email['content'],$email['header']->fromaddress);
                       if($insert_status){
                           $cnt++;
                       }
                    }

                }
                if($cnt){
                    $this->notice('Total ticket has been generated: '.$cnt);
                }
            }else{
                $this->notice('No new email found!','error');
            }
        }else{
            $this->notice('Can not connect with email server.Please try after some time!','error');
        }
    }
    
}
