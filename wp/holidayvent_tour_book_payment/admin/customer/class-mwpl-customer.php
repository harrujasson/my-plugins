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
class MWPL_Customer_Account   {
    
    use MWPL_Common;
    use MWPL_Roles;
    use MPWL_Authorized;
    
    private $role;
    private $userid;
    private $order ='';
    private $transaction ='';
    private $order_log='';
    
    
    public function __construct($user_id, $role) {
        
        
        if(!isset($_SESSION)) {
            session_start();
        }
        
        $this->role = $role;
        $this->userid =  $user_id;        
        $this->is_customer_authorized($this->role);
        
        //$this->is_customer_authorized($this->role);       
        /*Ticket manage ajax*/       
        add_action('wp_ajax_tourordermanagecustomer',array(&$this,'order_show_list'));
        add_action('wp_ajax_nopriv_tourordermanagecustomer',array(&$this,'order_show_list'));
        
        
        
        /*Table name defined*/
        global $wpdb;
        $this->order=$wpdb->prefix."mwpl_tour_order";
        $this->transaction=$wpdb->prefix."mwpl_tour_order_transaction";  
        $this->order_log=$wpdb->prefix."mwpl_tour_order_log";
    }
    
    function show(){ 
        $this->load_view_admin('customer/view/dashboard.php');
    }
    
    function order_show_list(){ 
        
        $aColumns = array("id", "tour","transaction","");
        $condition=array();
        $condition[] =' customer_id='.$this->userid;
        if($_POST['order_id'] !=""){
            $condition[]=" id = ".$_POST['order_id']." ";
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
        
        if(!empty($details)):       
        foreach($details as $k=>$v){     
            
            $transaction='';
            if($v['transaction'] == ""){
                $transaction = '<span class="badge badge-danger">Pending</span>';
            }else{
                $transaction = '<span class="badge badge-success">'.$v['transaction'].'</span>';
            }
            $button = '<a href="'. site_url('customer-account/details/'.$v['id']).'" class="btn btnView">Details</a>';
            $output['aaData'][] = array($v['id'],  $v['tour'], $transaction ,$button);        
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
                     $data[$i]['title']=$r->title;
                     $data[$i]['tour']='<a target="_blank" href="'.get_permalink($r->tour_id).'">'.$this->get_post_field_by_id($r->tour_id).'</a>';;    
                     $data[$i]['transaction']=$r->transaction;
                     $i+=1;  
                }
                return $data;
            }
        }
    }
    /*Order Details*/
    function order_details($id=0){
        
        $record = $this->get_record_by_id($this->order, array('customer_id'=> $this->userid,'id'=>$id));       
        if(empty($record)){
            $this->notice_front('Something went wrong.Please try again!','danger');
            @wp_redirect(site_url('customer-account')); 
            return false;
        }
        $content['r'] = $record;       
        $content['call'] = $this;
        $content['trans'] = $this->get_record_by_id($this->transaction, array('order_id'=>$id,'status'=>'Paid'));
        $content['status'] = $this->get_records($this->order_log, array('order_id'=>$id),array('id DESC'));
        $this->load_view_admin('customer/view/order/details.php',$content);       
    }
    function profile(){
        $content['r'] = $this->get_user_by_id($this->userid);
        $content['call'] = $this;
        //echo "<pre>"; print_r($content); echo "</pre>"; die();
        $this->load_view_admin('customer/view/profile.php',$content); 
    }
    function payment_process_pending($order_id=0){
        $order_details = $this->get_record_by_id($this->order, array('id'=>$order_id));
        if(!empty($order_details)){           
            $payment =new MWPL_Ccavenue($this->userid);
            $payment->set_fields($order_id, $order_details->grand_total);   
        }else{
            $this->notice_front('Order not found!','danger');
            @wp_redirect(site_url('customer-account/details/'.$order_id)); 
            return false;
        }
        
    }
    
    function load_module() {
        $page_node_1='';
        $page_node_2=''; 
        $node='';
       // echo "Node First: ", get_query_var( 'node_first' )." Second: ".get_query_var( 'node_second' ); die();
        
        if( false !== get_query_var( 'node_first' ) ){            
            $page_node_1 = get_query_var( 'node_first' );
        }
        if( false !== get_query_var( 'node_second' ) ){
            $page_node_2 = get_query_var( 'node_second' );
        }
        
        if($page_node_1!=""){
            $node = $page_node_1;
        }else{
            $node = $page_node_2;
        }
      
        switch ($node) {
            case 'create':
                $this->create();
                break;
            case 'details':
                $this->order_details($page_node_2);
                break;
            case 'profile':
                $this->profile();
                break;
            case 'payment':
                $this->payment_process_pending($page_node_2);
                break;
            

            default:
                $this->show();
                break;
        }
    }
}
