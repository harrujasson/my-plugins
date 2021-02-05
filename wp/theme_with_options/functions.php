<?php

/*Constants Global*/
define("MWPL_PARTIALS", get_template_directory().'/inc/partials/');
define("MWPL_TEMPLATE", get_template_directory());
define("MWPL_PARTIALS_URL", get_template_directory_uri().'/inc/partials/');

/*Themes Option*/
$themeOptions = get_option( "mwpl_theme_settings" );
define("SITE_EMAIL", $themeOptions['mwpl_email']);
define("SITE_PHONE", $themeOptions['mwpl_phone']);
define("SITE_ADDRESS", $themeOptions['mwpl_address']);


if ( ! function_exists( 'ashs_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ashs_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Osnic Tech, use a find and replace
		 * to change 'ashs' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ashs', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ashs' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ashs_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ashs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ashs_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ashs_content_width', 640 );
}
add_action( 'after_setup_theme', 'ashs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ashs_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar MWPL', 'ashs' ),
		'id'            => 'sidebar-1',                
		'description'   => esc_html__( 'Add widgets here.', 'ashs' ),
		'before_widget' => '',
		'after_widget'  => '<hr>',
		'before_title'  => '<h4 class="heading-primary">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'ashs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ashs_scripts() {
	
}
add_action( 'wp_enqueue_scripts', 'ashs_scripts' );

function special_nav_class($classes, $item){
    if( in_array('current-menu-item', $classes) ){
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);



require get_template_directory() . '/inc/Common.php';
if ( is_admin() ) {
    require get_template_directory() . '/inc/Themeoptions.php';
    
}
require get_template_directory() . '/inc/Front.php';

function get_image_featured($id=0,$size=''){
    $object = new MWPL_Theme_Front();
    return $object->getImageMWPL($id,$size);
}
function get_meta_info($postid=0,$meta_name=''){
    $object = new MWPL_Theme_Front();
    return $object->getmetinfo($postid,$meta_name);
}

function split_content($fcontent="",$len=0){
    $fcontent = strip_tags($fcontent);
    if(strlen($fcontent) > $len){
        return substr($fcontent, 0,$len).'..';
    }else{
        return $fcontent;
    }
}

add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );
function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'nav-link'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}

add_filter( 'previous_post_link', 'filter_single_post_pagination', 10, 4);
add_filter( 'next_post_link', 'filter_single_post_pagination', 10, 4);

function filter_single_post_pagination($output, $format, $link, $post){
    $icon1='';
    $icon2='';
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request)).'/';
    $title = 'Previous';
    $url   = get_permalink($post->ID);
    $class = 'single_pagination_prev';
    $rel   = 'prev';
    $icon1 = '<i class="fa fa-long-arrow-right"></i>';
    
    
    if('next_post_link' === current_filter()){
        $title = 'Next';
        $class = 'single_pagination_next';
        $rel   = 'next';
        $icon2 = '<i class="fa fa-long-arrow-left"></i>';
        $icon1='';
    }
    if($url == $current_url){
        $url= 'javascript:void(0);';
        $class.=' disabled';
    }
    return "<a href='$url' rel='$rel' class='$class pagination_links'> $icon2 $title $icon1</a>";
    
}

function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' );

function getThemeInfo($field=''){
    $themeOptions = get_option( "mwpl_theme_settings" );
    switch($field){
        case "logo":
            $image= $themeOptions['mwpl_logo'];
            if($image!=""){
                $imageSrc =  wp_get_attachment_image_src($image, 'orignal');
                return $imageSrc[0];
            }
            break;
        case "backgroundImage":
            $image = $themeOptions['mwpl_background'];
            if($image!=""){
                $imageSrc =  wp_get_attachment_image_src($image, 'orignal');
                return $imageSrc[0];
            }
            break;
        
        case "backgroundColor":
            return $themeOptions['mwpl_background_color'];
            break;
        
        case "topBarColor":
            return $themeOptions['mwpl_topbar_color'];
            break;
        case "topBarHeight":
            $height = $themeOptions['mwpl_topbar_height'];
            if(!empty($height)){
                return $height.'px';
            }else{
                return "auto";
            }
            break;
        case "headIcon":
            $image = $themeOptions['mwpl_head_icon'];
            if($image!=""){
                $imageSrc =  wp_get_attachment_image_src($image, 'orignal');
                return $imageSrc[0];
            }
            
            break;
        case "headTitle":
            return $themeOptions['mwpl_head_title'];
            break;
        case "headTitleFontSizeWeb":
            
            $fontSize = $themeOptions['mwpl_head_title_font_size_web'];
            if(!empty($fontSize)){
                return $fontSize.'px';
            }else{
                return "auto";
            }
            
            break;
        case "headTitleFontSizeTablet":
            
            $fontSize = $themeOptions['mwpl_head_title_font_size_tablet'];
            if(!empty($fontSize)){
                return $fontSize.'px';
            }else{
                return "auto";
            }
            
            break;
        case "headTitleFontSizeMobile":
            
            $fontSize = $themeOptions['mwpl_head_title_font_size_mobile'];
            if(!empty($fontSize)){
                return $fontSize.'px';
            }else{
                return "auto";
            }
            
            break;    
        case "headTitleFontStyle":
            $fontStyle = $themeOptions['mwpl_head_title_font_style'];
            if($fontStyle!=""){
                $rawStyle = explode(",", $fontStyle);
                $fontReturn =  "'". $rawStyle[0] ."'";
                $fontReturn.=','.$rawStyle[1];
                return $fontReturn;
            }
            break;
        case "headSubTitle":
            return $themeOptions['mwpl_head_titlesub'];
            break;
        case "headSubTitleFontSizeWeb":
            
            $fontSize = $themeOptions['mwpl_head_titlesub_font_size_web'];
            if(!empty($fontSize)){
                return $fontSize.'px';
            }else{
                return "auto";
            }
            
            break;
        case "headSubTitleFontSizeTablet":
            
            $fontSize = $themeOptions['mwpl_head_titlesub_font_size_tablet'];
            if(!empty($fontSize)){
                return $fontSize.'px';
            }else{
                return "auto";
            }
            
            break;
        case "headSubTitleFontSizeMobile":
            
            $fontSize = $themeOptions['mwpl_head_titlesub_font_size_mobile'];
            if(!empty($fontSize)){
                return $fontSize.'px';
            }else{
                return "auto";
            }
            
            break;    
            
            
            
        case "headSubTitleFontStyle":
            
            $fontStyle = $themeOptions['mwpl_head_titlesub_font_style'];
            if($fontStyle!=""){
                $rawStyle = explode(",", $fontStyle);
                $fontReturn =  "'". $rawStyle[0] ."'";
                $fontReturn.=','.$rawStyle[1];
                return $fontReturn;
            }
            
            break;
        case "footerCopyright":
            return $themeOptions['mwpl_footer_copyright'];
            break;
        case "footerScriptCode":
            return $themeOptions['mwpl_footer_scriptCode'];
            break;
        case "mwplFooterIcons":
            return $themeOptions['mwpl_footer_icons'];
            break;
    }
}


require get_template_directory() .'/theme-diagnos/theme-diagnos.php';
$systediagnos = new ThemeUpdateChecker(
	'mwpl',      //theme folder name                                       
	'https://www.maansawebworld.com/update-package/plugins/casinobono/brands-table/theme/details.json'
);

