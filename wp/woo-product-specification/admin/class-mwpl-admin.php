<?php
class Mwpl_Woo_Product_Specifications_Admin {
 
    function __construct(){
        add_filter( 'woocommerce_product_data_tabs', array($this,'mwpl_specification_product_tab') , 10 , 1 );
        add_action( 'woocommerce_product_data_panels', array($this,'mwpl_specification_tab_data'),10,1 );
        add_action( 'woocommerce_process_product_meta', array($this,'mwpl_specification_tab_data_save') );
    }
    
    function mwpl_specification_product_tab( $default_tabs ) {
        
        $default_tabs['custom_tab'] = array(
            'label'   =>  __( 'Product Specifications', 'domain' ),
            'target'  =>  'mwpl_specification_tab_data',
            'priority' => 60,
            'class'   => array()
        );
        return $default_tabs;
    }
    
    function mwpl_specification_tab_data($post) {
        global $woocommerce, $post;
        require_once PRD_ADMIN_PATH.'partials/information.php';  
    }
    function mwpl_specification_tab_data_save($post_id){
        
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( isset( $_POST['mwpl_product_specifications']['specification'] ) ) {
            update_post_meta( $post_id, 'mwpl_product_specification', json_encode($_POST['mwpl_product_specifications']['specification']));
        }else{
            update_post_meta( $post_id, 'mwpl_product_specification', '');
        }
        
        if ( isset( $_POST['mwpl_product_specifications_details']) ) {
            update_post_meta( $post_id, 'mwpl_product_specification_details', $_POST['mwpl_product_specifications_details']);
        }
        
        
        
        if ( isset( $_POST['mwpl_product_specification_manuals_installation']) ) {
            update_post_meta( $post_id, 'mwpl_product_specification_manuals_installation', $_POST['mwpl_product_specification_manuals_installation']);
        }
        if ( isset( $_POST['mwpl_product_specification_warranty']) ) {
            update_post_meta( $post_id, 'mwpl_product_specification_warranty', $_POST['mwpl_product_specification_warranty']);
        }
        if ( isset( $_POST['mwpl_product_specification_deliveryinfo']) ) {
            update_post_meta( $post_id, 'mwpl_product_specification_deliveryinfo', $_POST['mwpl_product_specification_deliveryinfo']);
        }
        
         if ( isset( $_POST['mwpl_product_specifications']['listpage'] ) ) {
            update_post_meta( $post_id, 'mwpl_product_specification_page', json_encode($_POST['mwpl_product_specifications']['listpage']));
        }else{
            update_post_meta( $post_id, 'mwpl_product_specification_page', '');
        }
        
        if(isset($_POST['mwpl_related_products'])){
            $product_relatd =  $_POST['mwpl_related_products'];
            update_post_meta( $post_id, 'mwpl_related_products_ids', $product_relatd );
        }else{
            update_post_meta( $post_id, 'mwpl_related_products_ids', '' );
        }
    }
    
    function getMetavalue($id,$key){
        return get_post_meta( $id, $key,  TRUE );     
    }
}

?>