<?php
require_once PRD_ADMIN_PATH.'class-common.php';
class MWPL_MANAGE extends MWPL_Common {
    function __construct() {       
        $this->catchrequest();
    }
    function load_heading(){
        $record =  $this->get_page_heading();   
        if($record){
            require_once PRD_ADMIN_PATH.'partials/mwpl_heading_edit.php'; 
        }else{
            require_once PRD_ADMIN_PATH.'partials/mwpl_heading_new.php'; 
        }
    }
    function load_list(){
        //$record = $this->get_record();
        //echo "<pre>"; print_r($record); echo "</pre>"; die();
        $record =  get_pages();
        require_once PRD_ADMIN_PATH.'partials/mwpl_list.php';        
    }
    function load_new(){
        if(!isset($_GET['page_id'])){
            $this->redirect_url('mwpl_link_generation&status=error');
        }
        if(isset($_GET['page_id']) && $_GET['page_id']==""){
            $this->redirect_url('mwpl_link_generation&status=error');
        }    
        $page_id = $_GET['page_id'];
        $pages = get_pages();
        foreach($pages as $p): 
            if($p->post_title!=""){
             $pages_arr[] = $p->post_title; 
            }else{
                $pages_arr[] = 'ID-'.$p->ID; 
            }

        endforeach;  
        $pages_arr = json_encode($pages_arr);
        require_once PRD_ADMIN_PATH.'partials/mwpl_new.php';        
    }
    function load_edit(){
        if(!isset($_GET['page_id'])){
            $this->redirect_url('mwpl_link_generation&status=error');
        }
        if(isset($_GET['page_id']) && $_GET['page_id']==""){
            $this->redirect_url('mwpl_link_generation&status=error');
        }
        
        $record = $this->get_record_page_id($_GET['page_id']);
        $page_id = $_GET['page_id'];
        
        $pages = get_pages();
        foreach($pages as $p): 
            if($p->post_title!=""){
             $pages_arr[] = $p->post_title; 
            }else{
                $pages_arr[] = 'ID-'.$p->ID; 
            }

        endforeach;  
        $pages_arr = json_encode($pages_arr);
        require_once PRD_ADMIN_PATH.'partials/mwpl_edit.php';        
    }
    function catchrequest(){
        if(isset($_POST['new_request'])){
            $exist = $this->get_record_page_id($_POST['page_id']);
            if(empty($exist)){
                if($this->insert_record_new()){
                    $this->redirect_url('mwpl_link_generation&status=3');
                }else{
                    $this->redirect_url('mwpl_link_generation&status=error');
                }
            }else{
                if($this->update_record($_POST['page_id'])){
                    $this->redirect_url('mwpl_link_generation&status=3');
                }else{
                    $this->redirect_url('mwpl_link_generation&status=error');
                }
            }
        }
        if(isset($_POST['update_request'])){
            if($this->update_record_replace($_POST['page_id'])){
                $this->redirect_url('mwpl_link_generation&status=2');
            }else{
                $this->redirect_url('mwpl_link_generation&status=error');
            }
        }
        
        if(isset($_GET['delete']) && $_GET['delete']!=""){
            if($this->delete_record($_GET['delete'])){
                $this->redirect_url('mwpl_link_generation&status=1');
            }else{
                $this->redirect_url('mwpl_link_generation&status=error');
            }
        }
        
        if(isset($_POST['update_request_heading'])){
           
            if($this->update_record_heading()){
                $this->redirect_url('mwpl_link_generation_heading&status=2');
            }else{
                $this->redirect_url('mwpl_link_generation_heading&status=error');
            }
        }
        if(isset($_POST['new_request_heading'])){
           
            if($this->new_record_heading()){
                $this->redirect_url('mwpl_link_generation_heading&status=2');
            }else{
                $this->redirect_url('mwpl_link_generation_heading&status=error');
            }
        }
    }
    
    function total_links($page_id = 0){
        $record =  $this->get_record_page_id($page_id);
        if(!empty($record)){
            if($record->content!=""){
                $contentraw = json_decode($record->content);
                $content = $contentraw->data;
                return count($content->company_name);
            }
        }else{
            return 0;
        }       
    }
    
}
?>