<?php

Class MWPL_Themeoptions{
    
    use MWPL_Theme_Common;
    
    function __construct() {
        add_action( 'init',  array($this,'mwpl_admin_init')  );
        add_action( 'admin_menu', array($this,'mwpl_settings_page_init')  );
    }
    
    function mwpl_admin_init() {
	$settings = get_option( "mwpl_theme_settings" );
	if ( empty( $settings ) ) {
		$settings = array(
			'mwpl_intro' => 'Some intro text for the home page',
			'mwpl_tag_class' => false,
			'mwpl_ga' => false
		);
		add_option( "mwpl_theme_settings", $settings, '', 'yes' );
	}	
    }

    function mwpl_settings_page_init() {
            $theme_data = get_theme_data( MWPL_TEMPLATE . '/style.css' );
            $settings_page = add_theme_page( $theme_data['Name']. ' Theme Settings', $theme_data['Name']. ' Theme Settings', 'edit_theme_options', 'theme-settings',  array($this,'mwpl_settings_page')  );
            add_action( "load-{$settings_page}",  array($this,'mwpl_load_settings_page')  );
    }

    function mwpl_load_settings_page() {
            if ( $_POST["mwpl-settings-submit"] == 'Y' ) {
                    check_admin_referer( "mwpl-settings-page" );
                    mwpl_save_theme_settings();
                    $url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
                    wp_redirect(admin_url('themes.php?page=theme-settings&'.$url_parameters));
                    exit;
            }
    }

    function mwpl_save_theme_settings() {
            global $pagenow;
            $settings = get_option( "mwpl_theme_settings" );

            if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ){ 
                    if ( isset ( $_GET['tab'] ) )
                    $tab = $_GET['tab']; 
                else
                    $tab = 'general'; 

                switch ( $tab ){ 
                    case 'footer' : 
                                    $settings['mwpl_ga']  = $_POST['mwpl_ga'];
                            break;
                            case 'general' : 
                                    $settings['mwpl_address']	  = $_POST['mwpl_address'];
                                    $settings['mwpl_phone']	  = $_POST['mwpl_phone'];
                                    $settings['mwpl_phone_whatsapp']	  = $_POST['mwpl_phone_whatsapp'];
                            break;
                    case 'social' : 
                                    $settings['mwpl_social_link_fb']  = $_POST['mwpl_social_link_fb'];
                                    $settings['mwpl_social_link_tw']  = $_POST['mwpl_social_link_tw'];
                                    $settings['mwpl_social_link_in']  = $_POST['mwpl_social_link_in'];
                    break;

                }
            }

            if( !current_user_can( 'unfiltered_html' ) ){
                
                    if ( $settings['mwpl_address'] )
                            $settings['mwpl_address'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_address'] ) ) );
                    if ( $settings['mwpl_phone'] )
                            $settings['mwpl_phone'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_phone'] ) ) );
                    if ( $settings['mwpl_phone_whatsapp'] )
                            $settings['mwpl_phone_whatsapp'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_phone_whatsapp'] ) ) );
                
                
                    if ( $settings['mwpl_ga']  )
                            $settings['mwpl_ga'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_ga'] ) ) );
                    
                    if ( $settings['mwpl_social_link_fb'] )
                            $settings['mwpl_social_link_fb'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_social_link_fb'] ) ) );
                     if ( $settings['mwpl_social_link_tw'] )
                            $settings['mwpl_social_link_tw'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_social_link_tw'] ) ) );
                      if ( $settings['mwpl_social_link_in'] )
                            $settings['mwpl_social_link_in'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['mwpl_social_link_in'] ) ) );
            }

            $updated = update_option( "mwpl_theme_settings", $settings );
    }

    function mwpl_admin_tabs( $current = 'general' ) { 
        $tabs = array( 'general' => 'General', 'footer' => 'Footer','social'=>'Social Links' ); 
        $links = array();
        echo '<div id="icon-themes" class="icon32"><br></div>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='?page=theme-settings&tab=$tab'>$name</a>";

        }
        echo '</h2>';
    }

    function mwpl_settings_page() {
            global $pagenow;
            $settings = get_option( "mwpl_theme_settings" );
            $theme_data = get_theme_data( MWPL_TEMPLATE . '/style.css' );
            ?>

            <div class="wrap">
                    <h2><?php echo $theme_data['Name']; ?> Theme Settings</h2>

                    <?php
                            if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme Settings updated.</p></div>';

                            if ( isset ( $_GET['tab'] ) ) $this->mwpl_admin_tabs($_GET['tab']); else     $this->mwpl_admin_tabs('general');
                    ?>

                    <div id="poststuff">
                            <form method="post" action="<?php admin_url( 'themes.php?page=theme-settings' ); ?>">
                                    <?php
                                    wp_nonce_field( "mwpl-settings-page" ); 

                                    if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ){ 

                                            if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
                                            else $tab = 'general'; 
                                            switch ( $tab ){

                                                    case 'social' :
                                                        $this->load_view('theme_setting/social',$settings);                                                            
                                                    break; 
                                                    case 'footer' : 
                                                        $this->load_view('theme_setting/footer',$settings);    
                                                           
                                                    break;
                                                    case 'general' : 
                                                        $this->load_view('theme_setting/general',$settings); 
                                                            
                                                    break;
                                            }
                                    }
                                    ?>
                                    <p class="submit" style="clear: both;">
                                            <input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
                                            <input type="hidden" name="mwpl-settings-submit" value="Y" />
                                    </p>
                            </form>


                    </div>

            </div>
    <?php
    }
}
$cpt_theme_options = new MWPL_Themeoptions();

