<?php

Class MWPL_Themeoptions{
    
    use MWPL_Theme_Common;
    
    function __construct() {
        add_action( 'admin_menu', array($this,'mwpl_settings_page_init')  );
        /*Ajax Save Information*/
        add_action( 'wp_ajax_nopriv_get', array($this,'save_data')  );
        add_action( 'wp_ajax_get', array($this,'save_data') );
    }
    
    function save_data(){
        check_admin_referer( "mwpl-settings-page" );
        $status = $this->mwpl_save_theme_settings();
        if($status){
            $data['status'] = 'success';
            $data['message'] = "Information has been saved.";
        }else{
            $data['status'] = 'error';
            $data['message'] = "Nothing save, Please try again";
        }
        echo json_encode($data);
        wp_die();
    }
   
    function mwpl_settings_page_init() {
            $theme_data = get_theme_data( MWPL_TEMPLATE . '/style.css' );
            $settings_page = add_theme_page( $theme_data['Name']. ' Theme Settings', $theme_data['Name']. ' Theme Settings', 'edit_theme_options', 'theme-settings',  array($this,'mwpl_settings_page')  );
            
    }
    
    function mwpl_save_theme_settings() {
            global $pagenow;
            $settings = get_option( "mwpl_theme_settings" );
            
                
                $settings['mwpl_address'] = $_POST['mwpl_address'];
                $settings['mwpl_phone']	  = $_POST['mwpl_phone'];
                $settings['mwpl_email']	  = $_POST['mwpl_email'];  
                $settings['mwpl_logo']	  = $_POST['mwpl_logo'];  
                $settings['mwpl_background']	  = $_POST['mwpl_background'];  
                $settings['mwpl_background_color']	  = $_POST['mwpl_background_color'];  
                
                $settings['mwpl_topbar_height']	  = $_POST['mwpl_topbar_height'];  
                $settings['mwpl_topbar_color']	  = $_POST['mwpl_topbar_color'];  
                
                $settings['mwpl_head_icon']	  = $_POST['mwpl_head_icon'];  
                $settings['mwpl_head_title']	  = $_POST['mwpl_head_title'];  
                $settings['mwpl_head_title_font_size_web']	  = $_POST['mwpl_head_title_font_size_web'];
                $settings['mwpl_head_title_font_size_tablet']	  = $_POST['mwpl_head_title_font_size_tablet'];
                $settings['mwpl_head_title_font_size_mobile']	  = $_POST['mwpl_head_title_font_size_mobile'];
                $settings['mwpl_head_title_font_style']	  = $_POST['mwpl_head_title_font_style'];  
                $settings['mwpl_head_titlesub']	  = $_POST['mwpl_head_titlesub'];  
                $settings['mwpl_head_titlesub_font_size_web']	  = $_POST['mwpl_head_titlesub_font_size_web'];  
                $settings['mwpl_head_titlesub_font_size_tablet']	  = $_POST['mwpl_head_titlesub_font_size_tablet'];  
                $settings['mwpl_head_titlesub_font_size_mobile']	  = $_POST['mwpl_head_titlesub_font_size_mobile'];  
                $settings['mwpl_head_titlesub_font_style']	  = $_POST['mwpl_head_titlesub_font_style'];  
                
                $settings['mwpl_footer_copyright']	  = $_POST['mwpl_footer_copyright'];  
                $settings['mwpl_footer_scriptCode']	  = $_POST['mwpl_footer_scriptCode']; 
                $settings['mwpl_footer_icons']	  = json_encode($_POST['mwpl_footer_icons']);
                
                
                
            

            if( !current_user_can( 'unfiltered_html' ) ){
                    if ( $settings['mwpl_address'] )
                            $settings['mwpl_address'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_address'] ) ) );
                    if ( $settings['mwpl_phone'] )
                            $settings['mwpl_phone'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_phone'] ) ) );
                    if ( $settings['mwpl_email'] )
                            $settings['mwpl_email'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_email'] ) ) );
                    if ( $settings['mwpl_logo'] )
                            $settings['mwpl_logo'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_logo'] ) ) );
                    if ( $settings['mwpl_background'] )
                            $settings['mwpl_background'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_background'] ) ) );
                    if ( $settings['mwpl_background_color'] )
                            $settings['mwpl_background_color'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_background_color'] ) ) );
                    
                    if ( $settings['mwpl_topbar_height'] )
                            $settings['mwpl_topbar_height'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_topbar_height'] ) ) );
                    if ( $settings['mwpl_topbar_color'] )
                            $settings['mwpl_topbar_color'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_topbar_color'] ) ) );
                    
                    
                    if ( $settings['mwpl_head_icon'] )
                            $settings['mwpl_head_icon'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_icon'] ) ) );
                    if ( $settings['mwpl_head_title'] )
                            $settings['mwpl_head_title'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_title'] ) ) );
                    
                    if ( $settings['mwpl_head_title_font_size_web'] )
                            $settings['mwpl_head_title_font_size_web'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_title_font_size_web'] ) ) );
                    if ( $settings['mwpl_head_title_font_size_tablet'] )
                            $settings['mwpl_head_title_font_size_tablet'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_title_font_size_tablet'] ) ) );
                    if ( $settings['mwpl_head_titlesub_font_size_mobile'] )
                            $settings['mwpl_head_titlesub_font_size_mobile'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_titlesub_font_size_mobile'] ) ) );
                    
                    if ( $settings['mwpl_head_title_font_style'] )
                            $settings['mwpl_head_title_font_style'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_title_font_style'] ) ) );
                    if ( $settings['mwpl_head_titlesub'] )
                            $settings['mwpl_head_titlesub'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_titlesub'] ) ) );
                    
                    if ( $settings['mwpl_head_titlesub_font_size_web'] )
                            $settings['mwpl_head_titlesub_font_size_web'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_titlesub_font_size_web'] ) ) );
                    if ( $settings['mwpl_head_titlesub_font_size_tablet'] )
                            $settings['mwpl_head_titlesub_font_size_tablet'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_titlesub_font_size_tablet'] ) ) );
                    if ( $settings['mwpl_head_titlesub_font_size_mobile'] )
                            $settings['mwpl_head_titlesub_font_size_mobile'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_titlesub_font_size_mobile'] ) ) );
                            
                    if ( $settings['mwpl_head_titlesub_font_style'] )
                            $settings['mwpl_head_titlesub_font_style'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_head_titlesub_font_style'] ) ) );
                    
                    if ( $settings['mwpl_footer_copyright'] )
                            $settings['mwpl_footer_copyright'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_footer_copyright'] ) ) );
                    if ( $settings['mwpl_footer_scriptCode'] )
                            $settings['mwpl_footer_scriptCode'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_footer_scriptCode'] ) ) );
                    if ( $settings['mwpl_footer_icons'] )
                            $settings['mwpl_footer_icons'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_footer_icons'] ) ) );
            }

            $updated = update_option( "mwpl_theme_settings", $settings );
            return $updated;
    }

    

    function mwpl_settings_page() {
        global $pagenow;
        $settings = get_option( "mwpl_theme_settings" );            
        $theme_data = get_theme_data( MWPL_TEMPLATE . '/style.css' );
        //wp_nonce_field( "mwpl-settings-page" ); 
        if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ){ 
            $settings['fontsLib'] = $this->googleFontApi();
            $this->load_view('theme_setting/general',$settings); 
        }             
    }
    
    function googleFontApi(){
        $URL = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDAvDkjCjqQCr9X2BcTIlxUnJsc4DLAz4Y';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }
}
$cpt_theme_options = new MWPL_Themeoptions();

