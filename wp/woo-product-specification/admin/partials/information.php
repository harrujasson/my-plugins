<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
<link rel="stylesheet" href="<?=PRD_ADMIN_URL?>assets/style.css" />
<div id="mwpl_specification_tab_data" class="panel woocommerce_options_panel">
    <div class="full-width mwpl_float-left" >
        <h3 class="mwpl_outer_heading">Product View Page</h3>
    </div>
    <div class="mwpl_pannel">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">Product Details</span></div>
            
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down" style="display: block;"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up" style="display: none;"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body">
            <div class="mwpl_container">
                
                <?php wp_editor( htmlspecialchars_decode($this->getMetavalue($post->ID, "mwpl_product_specification_details")), 'mwpl_product_specifications_details', array("media_buttons" => false) ); ?>
            </div>
        </div>
    </div>
    
    <div class="mwpl_pannel ">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">Product Specifications</span></div>
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body mwpl_hide">
            <div class="mwpl_container">
                <div class="full-width mwpl_addMoreContainer">
                    <button type="button" class="button button-primary" id="more_record">Add more</button>
                </div>
                
                <div class="mwpl_preContainer">
                    <div class="mwpl_emptyContainer" style="display: none;" >
                        <div class="fieldsContainer full-width">
                            <div class="mwpl_w-40">
                                <input type="text" name="mwpl_product_specifications[specification][label][]" class="mwpl_inputs" placeholder="Label Name">
                            </div>
                            <div class="mwpl_w-40">
                                <input type="text"  name="mwpl_product_specifications[specification][value][]" class="mwpl_inputs" placeholder="Field Value">
                            </div>
                            <div class="mwpl_w-20 removeContainer"><a href="javascript:void(0);" class="mwpl_removeBtn remove_container">Remove</a></div>
                        </div>
                    </div>
                    <div class="load_html" id='sortable'>
                        <?php $fieldsAll=  $this->getMetavalue($post->ID, "mwpl_product_specification");?>
                        <?php $fields = json_decode($fieldsAll); ?>
                        <?php if(!empty($fields)): ?>
                        <?php for($i=0;$i<count($fields->label);$i++): ?>
                        <?php if($fields->label[$i]!=""): ?>
                        <div class="fieldsContainer full-width">
                            <div class="mwpl_w-40">
                                <input type="text" name="mwpl_product_specifications[specification][label][]" class="mwpl_inputs" placeholder="Label Name" value="<?= $fields->label[$i]?>">
                            </div>
                            <div class="mwpl_w-40">
                                <input type="text" name="mwpl_product_specifications[specification][value][]" class="mwpl_inputs" placeholder="Field Value" value="<?= $fields->value[$i]?>">
                            </div>
                            <div class="mwpl_w-20 removeContainer"><a href="javascript:void(0);" class="mwpl_removeBtn remove_container">Remove</a></div>
                        </div>
                        <?php endif; ?>
                        <?php endfor; ?>
                        <?php endif; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="mwpl_pannel">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">Manuals & Installation</span></div>
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body mwpl_hide">
            <div class="mwpl_container">
                
                <?php wp_editor( htmlspecialchars_decode($this->getMetavalue($post->ID, "mwpl_product_specification_manuals_installation")), 'mwpl_product_specification_manuals_installation', array("media_buttons" => false) ); ?>
            </div>
        </div>
    </div>
    
    <div class="mwpl_pannel">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">Warranty</span></div>
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body mwpl_hide">
            <div class="mwpl_container">
                
                <?php wp_editor( htmlspecialchars_decode($this->getMetavalue($post->ID, "mwpl_product_specification_warranty")), 'mwpl_product_specification_warranty', array("media_buttons" => false) ); ?>
            </div>
        </div>
    </div>
    
    <div class="mwpl_pannel">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">Delivery Info</span></div>
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body mwpl_hide">
            <div class="mwpl_container">
                <?php wp_editor( htmlspecialchars_decode($this->getMetavalue($post->ID, "mwpl_product_specification_deliveryinfo")), 'mwpl_product_specification_deliveryinfo', array("media_buttons" => false) ); ?>
            </div>
        </div>
    </div>
    
    
    <div class="mwpl_pannel">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">What you will need</span></div>
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body mwpl_hide">
            <div class="mwpl_container">
                
                <select class="wc-product-search" multiple="multiple" style="width: 90%;" id="upsizing_products" name="mwpl_related_products[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
                    <?php
                        $product_ids = get_post_meta( $post->ID, 'mwpl_related_products_ids', true );
                        foreach ( $product_ids as $product_id ) {
                            $product = wc_get_product( $product_id );
                            if ( is_object( $product ) ) {
                                echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name()) . '</option>';
                            }
                        }
                    ?>
                </select> <?php echo wc_help_tip( __( 'Select Related Products Here.', 'woocommerce' ) ); ?>
            </div>
        </div>
    </div>
    
    <div class="full-width mwpl_float-left" >
        <h3 class="mwpl_outer_heading">List Product Page</h3>
    </div>
    
    
    <div class="mwpl_pannel ">
        <div class="mwpl_pannel_heading">
            <div class="mwpl_heading_text_container"><span class="mwpl_heading">Product Extra Information</span></div>
            <div class="mwpl_options_heading">
                <div class ="mwpl_visible_down"><span class="fa fa-caret-down" ></span></div>
                <div class ="mwpl_visible_up"><span class="fa fa-caret-up " ></span></div>
            </div>
        </div>
        <div class="mwpl_pannel_body mwpl_hide">
            <div class="mwpl_container">
                <div class="full-width mwpl_addMoreContainer">
                    <button type="button" class="button button-primary" id="more_record_page">Add more</button>
                </div>
                
                <div class="mwpl_preContainerPage">
                    <div class="mwpl_emptyContainerPage" style="display: none;" >
                        <div class="fieldsContainerPage full-width">
                            <div class="mwpl_w-40">
                                <input type="text" name="mwpl_product_specifications[listpage][label][]" class="mwpl_inputs" placeholder="Label Name">
                            </div>
                            <div class="mwpl_w-40">
                                <input type="text"  name="mwpl_product_specifications[listpage][value][]" class="mwpl_inputs" placeholder="Field Value">
                            </div>
                            <div class="mwpl_w-20 removeContainer"><a href="javascript:void(0);" class="mwpl_removeBtn remove_container">Remove</a></div>
                        </div>
                    </div>
                    <div class="load_html_page" id='sortable_page'>
                        <?php $fieldsAll=  $this->getMetavalue($post->ID, "mwpl_product_specification_page");?>
                        <?php $fields = json_decode($fieldsAll); ?>
                        <?php if(!empty($fields)): ?>
                        <?php for($i=0;$i<count($fields->label);$i++): ?>
                        <?php if($fields->label[$i]!=""): ?>
                        <div class="fieldsContainer full-width">
                            <div class="mwpl_w-40">
                                <input type="text" name="mwpl_product_specifications[listpage][label][]" class="mwpl_inputs" placeholder="Label Name" value="<?= $fields->label[$i]?>">
                            </div>
                            <div class="mwpl_w-40">
                                <input type="text" name="mwpl_product_specifications[listpage][value][]" class="mwpl_inputs" placeholder="Field Value" value="<?= $fields->value[$i]?>">
                            </div>
                            <div class="mwpl_w-20 removeContainer"><a href="javascript:void(0);" class="mwpl_removeBtn remove_container">Remove</a></div>
                        </div>
                        <?php endif; ?>
                        <?php endfor; ?>
                        <?php endif; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=PRD_ADMIN_URL?>assets/script.js"></script>