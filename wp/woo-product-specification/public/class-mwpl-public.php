<?php
class Mwpl_Woo_Product_Specifications_Public {
 
    function __construct(){
        add_action( 'woocommerce_after_add_to_cart_button', array($this,'productSpecificationShow' ));
        add_action( 'woocommerce_after_shop_loop_item', array($this,'shopListPageInformation'),10 );
        add_action( 'template_redirect', array($this,'mpwl_add_to_cart') );
    }
    
    function productSpecificationShow(){
        global $woocommerce, $post;
        include(PRD_PUBLIC_PATH.'partials/single.php'); 
    }
    
    function shopListPageInformation(){
        global $woocommerce, $post;
        $list = array();
        $group = array();
        $record = $this->getMetavalue($post->ID, "mwpl_product_specification_page");
        $fields = json_decode($record);
        $groupCnt =0;
        $isRecord = 0;
        if(!empty($fields)){
            for($i=0;$i<count($fields->label);$i++):
                if($fields->label[$i] !="" && $fields->value[$i]!=""){
                    $group[$groupCnt]['label'] =  $fields->label[$i];
                    $group[$groupCnt]['value'] =  $fields->value[$i];
                    $groupCnt++;
                    $isRecord++;
                }else{
                    if($fields->label[$i]!=""){
                        $list[] = $fields->label[$i];
                        $isRecord++;
                    }
                }
                
            endfor;
            include( PRD_PUBLIC_PATH.'partials/list.php'); 
        }
        
        
        
    }
    function getMetavalue($id,$key){
        return get_post_meta( $id, $key,  TRUE );     
    }
    
    function getProductInformation($productId=0){
        $product = wc_get_product( $productId );
        $data['price'] = $product->get_price_html();
        $data['title'] = $product->get_title();
        $data['link'] = $product->get_permalink();
        return $data;
        
    }
    
    function mpwl_add_to_cart(){
        if(isset($_POST['related_products'])){
            if(!empty($_POST['related_products'])){
                foreach($_POST['related_products'] as $prod){
                    WC()->cart->add_to_cart( $prod );
                }
            }
        }
        
    }
}

?>