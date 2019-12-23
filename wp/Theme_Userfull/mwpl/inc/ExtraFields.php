<?php

Class MWPL_Extra_fields {
    use MWPL_Theme_Common;
    function __construct(){
        add_action( 'save_post', array($this,'metabox_save') );
    }
    function load_client_review_meta_fields(){       
        add_action( 'add_meta_boxes', array($this,'client_review_metabox_add'));   
    }
    public function client_review_metabox_add(){       
        add_meta_box( 'wp_client_review_fields', 'Advance Details', array($this,'wp_client_review_fields_method'), 'mwpl_client_review', 'normal', 'high' );
    }
    function wp_client_review_fields_method($post){       
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
        $data['designation'] = $this->getMetavalue($post->ID, "client_review_designation");
        $data['comment'] = $this->getMetavalue($post->ID, "client_review_comment");
        $data['name'] = $this->getMetavalue($post->ID, "client_review_name");
        $this->load_view('extra_fields/review',$data);
    }
    
    /*Travel Package*/
    function load_travel_package_meta_fields(){
        add_action( 'add_meta_boxes', array($this,'travel_package_metabox_add'));  
    }
    function travel_package_metabox_add(){
        add_meta_box( 'wp_travel_package_fields', 'Advance Details', array($this,'wp_travel_package_fields_method'), 'mwpl_packages', 'normal', 'high' );
    }
    function wp_travel_package_fields_method($post){       
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
        $data['country'] = $this->getMetavalue($post->ID, "travel_package_country");        
        $this->load_view('extra_fields/travel_package',$data);
    }
    
    /*University*/
    function load_university_meta_fields(){
        add_action( 'add_meta_boxes', array($this,'university_metabox_add'));  
    }
    function university_metabox_add(){
        add_meta_box( 'wp_university_fields', 'Advance Details', array($this,'wp_university_fields_method'), 'mwpl_university', 'normal', 'high' );
    }
    function wp_university_fields_method($post){       
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
        $data['country'] = $this->getMetavalue($post->ID, "university_country");        
        $this->load_view('extra_fields/university',$data);
    }
    
 
    function metabox_save($post_id){
        global  $wpdb;
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
         // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;

        // now we can actually save the data
        $allowed = array( 
                'a' => array( // on allow a tags
                        'href' => array() // and those anchords can only have href attribute
                )
        );
        if(isset($_POST['client_review'])){
           update_post_meta( $post_id, 'client_review_comment', $_POST['client_review']['comment'] );       
           update_post_meta( $post_id, 'client_review_designation', $_POST['client_review']['designation'] );  
           update_post_meta($post_id, 'client_review_name', $_POST['client_review']['name']);
        }  
        if(isset($_POST['travel_package'])){
           update_post_meta( $post_id, 'travel_package_country', $_POST['travel_package']['country'] );  
        }
        if(isset($_POST['university'])){
           update_post_meta( $post_id, 'university_country', $_POST['university']['country'] );  
        }
        
    }
}

