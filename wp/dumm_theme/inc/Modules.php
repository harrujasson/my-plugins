<?php

Class MWPL_Modules{
    
    use MWPL_Theme_Common;
    
    function __construct() {         
        add_action( 'init', array($this, 'MWPL_Create_CPT') );
    }
    function MWPL_Create_CPT(){
        $this->section_init('mwpl_banner','Home Banner', false, array( 'title','thumbnail') ,'Banner Picture');
    }
    public function section_init($cpt_name='',$post_name='', $public_show =false, $support = array(), $featured_image ='Featured Image', $icon='dashicons-images-alt') {         
	$labels = array(
		'name'               => _x( $post_name, 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( $post_name, 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( $post_name, 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( $post_name, 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Fb_Display', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New '.$post_name, 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit '.$post_name, 'your-plugin-textdomain' ),
		'view_item'          => __( 'View '.$post_name, 'your-plugin-textdomain' ),
		'all_items'          => __( 'All '.$post_name, 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search '.$post_name, 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent'.$post_name.' :', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No '.$post_name.' Found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No '.$post_name.' Found in Trash.', 'your-plugin-textdomain' ),                
		'featured_image'        => __( $featured_image, 'textdomain' ),		
		'set_featured_image'    => __( 'Set '.$featured_image, 'textdomain' ),		
		'remove_featured_image' => _x( 'Remove '.$featured_image, 'textdomain' ),		
		'use_featured_image'    => _x( 'Use as '.$featured_image, 'textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,	
                'publicly_queryable' => true,
                'query_var'          => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
                'menu_icon'           => $icon,
		'supports'           => $support
	);

	register_post_type( $cpt_name, $args );  
        flush_rewrite_rules();
    }
    
}
$cpt_modules = new MWPL_Modules();

