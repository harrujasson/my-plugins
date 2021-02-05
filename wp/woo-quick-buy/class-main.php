<?php 
Class Mwpl_Woo_Quick_Buy{
    
    function __construct(){
        add_shortcode( 'mwpl-woo-quick-buy', array($this,'mwpl_quick_buy'));  
        add_filter ('add_to_cart_redirect', array($this,'redirect_to_checkout'));
        add_filter( 'woocommerce_is_sold_individually', array($this,'wc_remove_all_quantity_fields') , 10, 2 );
        add_filter('woocommerce_cart_item_permalink',array($this,'disable_link'));
    }
    
    function mwpl_quick_buy($atts){
        if(isset($atts['product']) && $atts['product']!=""){
            $class = '';
            $label='';
            if(isset($atts['class'])){
                $class = $atts['class'];
            }
            if(isset($atts['label'])){
                $label = $atts['label'];
            }
            if($this->is_cart( $atts['product'] ) == ""){
               echo '<a href="'. do_shortcode( '[add_to_cart_url id=' . $atts['product'] . ']' ).'" class="'.$class.'">'.$label.'</a>'; 
            }else{       
                echo '<a href="'.wc_get_checkout_url().'" class="'.$class.'">Buy Now</a>';
            }
        }
    }
    function redirect_to_checkout(){
        global $woocommerce;
        $checkout_url = $woocommerce->cart->get_checkout_url();
        return $checkout_url;
    }
    function is_cart($product_id=0){
        $product_cart_id = WC()->cart->generate_cart_id( $product_id );
        $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );
        return $in_cart;
    }
    function wc_remove_all_quantity_fields( $return, $product ) {
        return( true );
    }
    function disable_link(){
        return (false);
    }
}

?>