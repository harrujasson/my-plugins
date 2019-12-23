<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-common
 *
 * @author MWPL-04
 */
class MWPL_Common {
    public $table = '';
    function __construct() {
        global $wpdb;
        $this->table=$wpdb->prefix."mwpl_link_generation";    
    }
    
    function get_record(){
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM " .$wpdb->prefix."mwpl_link_generation" .' ORDER BY ID DESC' , ARRAY_A);
    }
    function get_record_page_id($id=0){        
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " .$wpdb->prefix."mwpl_link_generation" .' WHERE page_id = '.$id.' ORDER BY ID DESC',OBJECT );
    }
    function get_record_by_id($id){
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " .$wpdb->prefix."mwpl_link_generation" .' WHERE id = '.$id.' ORDER BY ID DESC',OBJECT );
    }
    function insert_record_new(){ 
        $content = $this->process_record($_POST['page_id']);       
        global $wpdb;        
        $status = $wpdb->insert($wpdb->prefix."mwpl_link_generation", array(            
            'content' => json_encode($content),
            'page_id' => $_POST['page_id']                      
        ));
        if($status){
            return true;
        }else{
            return false;
        }
       
    }
    function update_record($id=0){
        $content = $this->process_record($_POST['page_id']); 
        
        global $wpdb;       
        $status = $wpdb->update(
                $wpdb->prefix."mwpl_link_generation", 
                array(                        
                        'content' => json_encode($content),                                                    
                    ),
                array( 'page_id' => $id )
                );
       // echo $wpdb->last_error ; die();
       // echo $wpdb->last_query ; die();
        if($status){
            return true;
        }else{
            return false;
        }
    }
    
    function update_record_replace($id=0){  
        
        $content = $this->process_record_replace($_POST['page_id']);
        global $wpdb;       
        $status = $wpdb->update(
                $wpdb->prefix."mwpl_link_generation", 
                array(                        
                        'content' => json_encode($content),                                                    
                    ),
                array( 'page_id' => $id )
                );
       // echo $wpdb->last_error ; die();
       // echo $wpdb->last_query ; die();
        if($status){
            return true;
        }else{
            return false;
        }
    }
    
    function delete_record($id =0){
        global $wpdb;
        $status = $wpdb->delete( $wpdb->prefix."mwpl_link_generation", array( 'ID' => $id ) );
        if($status){
            return true;
        }else{
            return false;
        }
    }
    /*Replace exist record*/
    function process_record_replace($page_id=0){        
        $raw_request_filter = $this->array_filter_clean($_POST);        
        return $raw_request_filter;
    }
    
    /*Process record*/
    function process_record($page_id=0){
        $record_exist = array();
        $record_exist_final = array();
        $record_exist = $this->get_record_page_id($page_id);
        
        /*Cleaning array and remove blank values*/
        if(!empty($record_exist) && $record_exist->content!=""){
            $record_exist_content = json_decode($record_exist->content);  
            $record_exist_obj_to_array= (array)$record_exist_content->data;
            $record_exist_final['data'] = $record_exist_obj_to_array;
           
        }        
        $raw_request_filter = $this->array_filter_clean($_POST);
        //echo "<pre>"; print_r($raw_request_filter); print_r($record_exist_final); echo "</pre>"; die();
        $final_array =  array_merge_recursive($raw_request_filter,$record_exist_final);   
        return $final_array;
        //echo "<pre>"; print_r($final_array); echo "</pre>"; die();
    }
    
    function array_filter_clean($array = array()){
        $info = array();
        foreach($array['data'] as $key=>$value){
            unset($array['data'][$key][0]);
            $info['data'][$key] = array_values($array['data'][$key]); 
        }
        return $info;
    }
    
    function redirect_url($link){
        echo '<script>window.location="'.admin_url('admin.php?page='.$link).'";</script>';
    }
    
    /*Shortcode data display*/
    function get_record_display(){
        $page_id =  get_the_ID();        
        global $wpdb;        
        return $wpdb->get_results("SELECT * FROM " .$wpdb->prefix."mwpl_link_generation" ." WHERE page_id in($page_id, 0)  ORDER BY page_id DESC" , ARRAY_A);
    }   
    
    
    /*Heading*/
    function get_page_heading(){
        global $wpdb;       
        return $wpdb->get_row("SELECT * FROM " .$wpdb->prefix."mwpl_link_generation_heading",OBJECT );
    }
    function update_record_heading(){       
        global $wpdb;       
        $status = $wpdb->update(
                $wpdb->prefix."mwpl_link_generation_heading", 
                array(                        
                        'content' => json_encode($_POST['data']),                                                    
                    ),
                array( 'id' => 1)
                );
        if($status){
            return true;
        }else{
            return false;
        }
    }
    function new_record_heading(){
        global $wpdb;       
        $status = $wpdb->insert(
                $wpdb->prefix."mwpl_link_generation_heading", 
                array(                        
                        'content' => json_encode($_POST['data']),                                                    
                    )
                );
        if($status){
            return true;
        }else{
            return false;
        }
    }
    
    function check_page_exclude($prevent_page){
        if(!empty($prevent_page)){
            //$current_page =  get_the_title( get_the_ID());
            $current_page_post = get_post(get_the_ID());
            if(!empty($current_page_post)){
                $current_page = $current_page_post->post_title;
                $exclude_page = explode(",", $prevent_page);
                if(in_array($current_page, $exclude_page)){
                    return 1;
                }  
            }
        }
    }
}
