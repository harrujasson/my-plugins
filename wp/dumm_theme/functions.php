<?php
define("SITE_EMAIL", ' info@durantarms.co.uk');
define("SITE_PHONE", '01803 732240');
define("SITE_PHONE2", '');
define('FB', 'https://www.facebook.com/thedurantarms');
define('TW', 'https://twitter.com/durantarms');
define('INSTA', 'https://www.instagram.com/durantarms');


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



/**
 * Custom template tags for this theme.
 */
//require get_template_directory() . '/inc/template-tags.php';


/**
 * Load Jetpack compatibility file.
 */



require get_template_directory() . '/inc/Common.php';

function split_content($fcontent="",$len=0){
    $fcontent = strip_tags($fcontent);
    if(strlen($fcontent) > $len){
        return substr($fcontent, 0,$len).'..';
    }else{
        return $fcontent;
    }
}



add_filter ( 'nav_menu_css_class', 'so_37823371_menu_item_class', 10, 4 );

function so_37823371_menu_item_class ( $classes, $item, $args, $depth ){
  $classes[] = 'nav-item';
  return $classes;
}


add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'nav-link text-grey-c font-weight-bold'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}

add_action( 'wp_ajax_get_source', 'get_source' );
add_action( 'wp_ajax_nopriv_get_source', 'get_source' );

function get_source(){
   //$info =  get_post($_POST['id']);
    $destination = array();
    $cpt_obj = new Wp_HRTC_Routes();
    $location_posts = $cpt_obj->filterGet($_POST['id']);
    if(!empty($location_posts)){
        foreach($location_posts as $loc){
            $loc_id = $cpt_obj->getMetavalue($loc->ID, "route_destination");
            $destination[] = set_source_value(get_post($loc_id));
        }
        if(!empty($destination)){
            echo json_encode($destination); die();
        }
        
    }
    //$information = $cpt_obj->getMetavalue($_POST['id'], "route_destination");
    //echo "<pre>"; print_r($destination); echo "</pre>"; die();
}
function set_source_value($array = array()){
    if(!empty($array)){
        $data['id'] = $array->ID;
        $data['text'] = $array->post_title;
        return $data;
    }
}


function multiplef_fields_add(){
    require get_template_directory().'/inc/extra_fields.php';
    $obj_extra_fields = new Extra_fields();    
    if(isset($_GET['post']) && $_GET['post'] == "59"){  
        $obj_extra_fields->load_meta_fields();
    }
    if(isset($_GET['post']) && get_post_type($_GET['post']) == "eat" ){        
        $obj_extra_fields->load_meta_fields_eat();
    }
    if(isset($_GET['post_type']) && $_GET['post_type'] == "eat" ){        
        $obj_extra_fields->load_meta_fields_eat();
    }
    
}
add_action('admin_init', 'multiplef_fields_add');



