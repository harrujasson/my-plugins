<link rel="stylesheet" href="<?=PRD_PUBLIC_URL?>assets/style.css" />
<div class="mwpl_public_specification_container">
    
    <?php $detailsSingle =   $this->getMetavalue($post->ID, "mwpl_product_specification_details"); ?>
    <?php if($detailsSingle !=""): ?>
    <button class="accordion" type="button"><span class="product_details_icon"></span> Product Details</button>
    <div class="panel">
        <div class="mwpl_public_content_container">
            <?=$detailsSingle?>
        </div>
    </div>
    <?php endif; ?>
    
    
    <?php $specification=  $this->getMetavalue($post->ID, "mwpl_product_specification");?>
    <?php $fields = json_decode($specification); ?>
    <?php if(!empty($fields)): ?>
    <button class="accordion" type="button"><span class="product_details_specification_icon"></span> Product Specifications</button>
    <div class="panel">
        <div class="mwpl_public_content_container">
            <table class="mwpl_table_public_specification">
                <tbody>
                <?php for($i=0;$i<count($fields->label);$i++): ?>
                <?php if($fields->label[$i]!=""): ?>
                    <tr>
                        <th class="col label" scope="row"><?= $fields->label[$i]?></th>
                        <td class="col data" data-th="SKU"><?= $fields->value[$i]?></td>
                    </tr>   
                <?php endif; ?>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <?php $detailsInstallation =   $this->getMetavalue($post->ID, "mwpl_product_specification_manuals_installation"); ?>
    <?php if($detailsInstallation !=""): ?>
    <button class="accordion" type="button"><span class="product_details_manuals_icon"></span> Manuals & Installation</button>
    <div class="panel">
        <div class="mwpl_public_content_container">
            <?=$detailsInstallation?>
        </div>
    </div>
    <?php endif; ?>
    
    
    <?php $detailsWarranty =   $this->getMetavalue($post->ID, "mwpl_product_specification_warranty"); ?>
    <?php if($detailsWarranty !=""): ?>
    <button class="accordion" type="button"><span class="product_details_warranty_icon"></span> Warranty</button>
    <div class="panel">
        <div class="mwpl_public_content_container">
            <?=$detailsWarranty?>
        </div>
      
    </div>
    <?php endif; ?>
    
    <?php $detailsDelivery =   $this->getMetavalue($post->ID, "mwpl_product_specification_deliveryinfo"); ?>
    <?php if($detailsDelivery !=""): ?>
    <button class="accordion" type="button"><span class="product_details_delivery_icon"></span> Delivery Info</button>
    <div class="panel">
        <div class="mwpl_public_content_container">
            <?=$detailsDelivery?>
        </div>
    </div>
    <?php endif; ?>
    
    
    <?php $detailsNeed =   $this->getMetavalue($post->ID, "mwpl_related_products_ids"); ?>
    <?php if(!empty($detailsNeed)): ?>
    <button class="accordion" type="button"><span class="product_details_you_need_icon"></span> What you will need</button>
    <div class="panel">
        <div class="mwpl_public_content_container">
            <div class="mwpl_need_head">
                Check items to add to the cart or  <a href="javascript:void(0);" class="mwpl_need_select_all">select all</a>
            </div>
            <div class="mwpl_need_product_container">
                <?php $sr= 1; foreach($detailsNeed as $pd): ?>
                <?php $productDetails = $this->getProductInformation($pd); ?>
                <?php if($productDetails['price']!=""): ?>
                <div class="mwpl_need_product_row">
                    <?php if(!empty($productDetails['title'])): ?><div class="mwpl_need_product_title"><a href="<?=$productDetails['link']?>"><?= $productDetails['title']; ?></a></div><?php endif; ?>
                    <?php if(!empty($productDetails['price'])): ?><div class="mwpl_need_product_price"><?= $productDetails['price']; ?></div><?php endif; ?>
                    <div class="mwpl_need_product_cart">
                        <label for="mwpl_need_cart_<?=$sr?>">Select to cart </label> <input id="mwpl_need_cart_<?=$sr?>" type="checkbox" name="related_products[]" value="<?=$pd?>" class="mwpl_need_product_cart_chk">
                    </div>
                </div>
                <?php endif; ?>
                <?php $sr++; endforeach; ?>
            </div>
            
        </div>
    </div>
    <?php endif; ?>
</div>


<script type="text/javascript">
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}

jQuery(".mwpl_need_select_all").click(function(){
    jQuery(".mwpl_need_product_cart_chk").prop("checked",true);
});
</script>


