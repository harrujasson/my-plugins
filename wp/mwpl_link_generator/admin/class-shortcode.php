<?php
require_once PRD_ADMIN_PATH.'class-common.php';
class MWPL_Shortcode extends MWPL_Common {
    function __construct() {       
        
    }
    
    function load_record(){        
        ob_start();
        $heading  = $this->get_page_heading();
        $record =  $this->get_record_display();      
        include( PRD_PUBLIC_PATH.'partials/listtable.php');         
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }
}
?>