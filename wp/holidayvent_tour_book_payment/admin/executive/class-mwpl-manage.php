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
class MWPL_Executive  {
    
    use MWPL_Common;
    use MWPL_Roles;
    
    private $role;
    private $userid;
    private $order ='';
    private $transaction ='';
    private $order_log='';
    
    public function __construct($user_id, $role) {
        $this->role = $role;
        $this->userid =  $user_id;
        
        /*Ticket manage ajax*/
        add_action('wp_ajax_tourorderexecutivemanage',array(&$this,'order_list'));
        add_action('wp_ajax_nopriv_tourorderexecutivemanage',array(&$this,'order_list'));
        
        /*Table name defined*/
        global $wpdb;
        $this->order=$wpdb->prefix."mwpl_tour_order";
        $this->transaction=$wpdb->prefix."mwpl_tour_order_transaction"; 
        $this->order_log=$wpdb->prefix."mwpl_tour_order_log";
    }

    function show(){ 
        $this->load_view_admin('executive/view/list.php');
    }
    function details(){
        $id = 0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        $record = $this->get_record_by_id($this->order, array('id'=>$id,'staff_id'=> $this->userid));
        if(empty($record)){
            $this->notice('Invalid order id.Please try again!','danger');
            @wp_redirect(admin_url('admin.php?page=mwpl_order_executive')); 
            return false;
        }
        $content['r'] = $record;
        $content['trans'] = $this->get_record_by_id($this->transaction, array('order_id'=>$id,'status'=>'Paid'));
        $content['status'] = $this->get_records($this->order_log, array('order_id'=>$id),array('id DESC'));        
        $content['call'] = $this;
        $this->load_view_admin('executive/view/details.php',$content);
    }
    function order_list(){
         
        $aColumns = array("id", "title", "tour","transaction","","");
        $condition=array();
        $condition[] =' staff_id='.$this->userid;
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
        
        if(!empty($details)):       
        foreach($details as $k=>$v){
            $transaction='';
            $staff = '';
            if($v['transaction'] == ""){
                $transaction = '<span class="badge badge-danger">Pending</span>';
            }else{
                $transaction = '<span class="badge badge-success">'.$v['transaction'].'</span>';
            }
            
            
            $button = '<a href="admin.php?page=mwpl_order_view_executive&id='.$v['id'].'" class="btn btnView">Discussion</a>';
            $output['aaData'][] = array($v['id'], $v['tour'], $transaction ,$button);            
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
    
}
