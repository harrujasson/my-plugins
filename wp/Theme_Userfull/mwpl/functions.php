<?php
define("SITE_EMAIL", ' info@gbsolutionsonline.com');
define("SITE_PHONE", '+244 928606939');
define("SITE_WHATSUP", '+447566710740');
define('FB', '#');
define('TW', '#');
define('INSTA', '#');
define('ADDRESS', '');
define("MWPL_PARTIALS", get_template_directory().'/inc/partials/');
define("MWPL_TEMPLATE", get_template_directory());

define("MWPL_PARTIALS_URL", get_template_directory_uri().'/inc/partials/');



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
if ( is_admin() ) {
    require get_template_directory() . '/inc/Themeoptions.php';
    
}
require get_template_directory() . '/inc/Modules.php';
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


function multiplef_fields_add(){
    if(isset($_GET['post_type'])){
        $post_name = $_GET['post_type'];
    }else{
        $post_name = get_post_type($_GET['post']);
    }
    require get_template_directory().'/inc/ExtraFields.php';
    $obj_extra_fields = new MWPL_Extra_fields();    
    
    switch ($post_name){        
        case 'mwpl_university':
            $obj_extra_fields->load_university_meta_fields();
            break;
        case 'mwpl_packages':
            $obj_extra_fields->load_travel_package_meta_fields();
            break;
        case 'mwpl_client_review':           
            $obj_extra_fields->load_client_review_meta_fields();
            break;
        case 'mwpl_country_slider':
           // $obj_extra_fields->load_meta_fields();
            break;
        default :
            break;
    }
}
add_action('admin_init', 'multiplef_fields_add');

function page_numeric_posts_nav() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<ul class="pagination float-right">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="page-item">%s</li>' . "\n", get_previous_posts_link() );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s class="page-item"><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li class="page-item">…</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s class="page-item"><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="page-item">…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s class="page-item"><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="page-item">%s</li>' . "\n", get_next_posts_link() );
 
    echo '</ul>' . "\n";
 
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



