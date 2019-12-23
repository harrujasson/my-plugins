<?php  if(!empty($record) && !empty($heading)): ?>
<link rel="stylesheet" href="<?=PRD_PLUGIN_URL . '/public/css/raterater.css'?>">
<link rel="stylesheet" href="<?=PRD_PLUGIN_URL . '/public/css/custom.css'?>">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


<?php 
$page_string='<div class="iconsSize">';
foreach($record as $pgcnt){
    $pngcnt_raw = json_decode($pgcnt['content']);
    $page_content = $pngcnt_raw->data;
    for($i=0;$i<count($page_content->head_text);$i++){
        $img='';
        if($page_content->head_picture[$i]!=""):
            $img_src =  wp_get_attachment_image_src( $page_content->head_picture[$i], 'thumbnail' );
            $img='<img src="'.$img_src[0].'">';
        endif;
        $page_string.=$page_content->head_text[$i].$img;
    }
}
$page_string.='</div>';
echo $page_string;
?>
    
<?php  if($heading->content!=""): ?>
<?php $heading_data = json_decode($heading->content);    ?>                                             
                            
<div class="headrow small-hide">
    <?php for($i=0;$i<count($heading_data);$i++){?>
    <div class=""><?=$heading_data[$i]?></div>    
    <?php } ?>
</div>
<?php endif; ?>
<?php $cnt = 0; foreach($record as $r){
    
    $contentraw = json_decode($r['content']);        
    $content = $contentraw->data;
    //echo "<pre>"; print_r($content); echo "</pre>"; die();
?> 
<?php  for($i=0;$i<count($content->company_name);$i++){
    $field_5_len=0;
    if($content->field5[$i]): $field_5_len  = strlen($content->field5[$i]); endif;
        $field_tag_counter=0;
        //echo $content->exclude_page[$i];
        /*Checking for exclude pages*/
        if(!$this->check_page_exclude($content->exclude_page[$i])){
        
    ?>
        
<?php if(isset($content->show[$i]) && $content->show[$i] =="0" ){ $cnt++; ?>   
<div class="content-row  <?php if($field_5_len > 0 && $field_5_len >= 10){ echo "p-b-20"; }else{ echo "p-b-40"; } ?> p-t-10">
    
    <div class="content_wrap">
       <!--Ribbon code-->
       <?php if($content->ribbon_text[$i]!=""): ?>
       <div class="ribbon " id="ribbonHolder_<?=$i?>">
           <div class="ribbon_text" style="background-color: #<?php if($content->ribbon_bg[$i]!=""){echo $content->ribbon_bg[$i];}?>">
               <span style="color: #<?php if($content->ribbon_text_color[$i]!=""){echo $content->ribbon_text_color[$i];}?>"><?=$content->ribbon_text[$i]?></span>
           </div>
       </div>

       <style>
           #ribbonHolder_<?=$i?>::before, #ribbonHolder_<?=$i?>::after{
               border-color: #<?php if($content->ribbon_bg[$i]!=""){echo $content->ribbon_bg[$i];}?>;
           }
       </style>
       <?php endif; ?>
       <!--End Ribbon code-->


       <div class="rank small-hide">
           <div>
               <span><?=$cnt?></span>
           </div>
       </div>
       <div class="casino small-hide">
           <?php if($content->logo[$i]!=""): ?>
                   <?php $img =  wp_get_attachment_image_src( $content->logo[$i], 'full' ) ?>
                   <a href="<?= $content->company_link[$i] ?>" target="_blank"> <img class="aligncenter wp-image-1339 size-full" src="<?=$img[0]?>" ></a>
                   <?php endif; ?>

                   <?php if($content->company_name[$i]!=""): ?>    
                   <a  title="<?=$content->company_name[$i]?>" href="<?= $content->company_link[$i] ?>" target="_blank" rel="noopener"  class="logoHdng">
                       <p><strong><?=$content->company_name[$i]?></strong></p>
                   </a>   
                   <?php endif; ?>                           
       </div> 
       <div class="large-hide medium-back">        
           <div class="rank">
           <div>
               <span><?=$cnt?></span>
               <?php if($cnt==1): ?>
   <!--                <img class="" src="<?= PRD_PLUGIN_URL ?>/public/css/ico_bestdk_new.svg"/>  -->
               <?php endif; ?>
           </div>
       </div>
       <div class="casino">
           <?php if($content->logo[$i]!=""): ?>
                   <?php $img =  wp_get_attachment_image_src( $content->logo[$i], 'full' ) ?>
                       <a target="_blank" href="<?= $content->company_link[$i] ?>"> <img class="aligncenter wp-image-1339 size-full" src="<?=$img[0]?>" ></a>
                   <?php endif; ?>

                   <?php if($content->company_name[$i]!=""): ?>    
                   <a  title="<?=$content->company_name[$i]?>" href="<?= $content->company_link[$i] ?>" target="_blank" rel="noopener" class="logoHdng">
                       <p><strong><?=$content->company_name[$i]?></strong></p>
                   </a>   
                   <?php endif; ?>
       </div>

       </div>
       
        <p class="large-hide medium-hide w-back">
           <?php if($content->logo_licence[$i]!=""): ?>
          <?php $img =  wp_get_attachment_image_src( $content->logo_licence[$i], 'full' ) ?>
           <a href="<?= $content->company_link[$i] ?>" target="_blank"> <img class="size-full xs-image-licence" src="<?=$img[0]?>" ></a>
           <?php endif; ?>
           <?php if($content->paymenticon1[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->paymenticon1[$i], 'full' ) ?>
               <img class="pay-icon xs-image-licence" src="<?=$img[0]?>"/>
           <?php endif; ?>

           <?php if($content->paymenticon2[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->paymenticon2[$i], 'full' ) ?>
               <img class="pay-icon xs-image-licence" src="<?=$img[0]?>"/>
           <?php endif; ?>          
        </p>
        <div class="w-back pb-5"><div class="ratebox large-hide medium-hide" data-id="1" data-rating="<?= $content->ratting[$i] ?>"></div> </div>   

        
        
       <div class="dansk-licens xs-hide medium-hide">

           <?php if($content->logo_licence[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->logo_licence[$i], 'full' ) ?>
            <a href="<?= $content->company_link[$i] ?>" target="_blank"> <img class="aligncenter wp-image-1339 size-full abs" src="<?=$img[0]?>" ></a>
           <?php endif; ?>

           <!--NEW CODE ICON-->
           <?php if($content->paymenticon1[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->paymenticon1[$i], 'full' ) ?>
               <img class="pay-icon" src="<?=$img[0]?>"/>
           <?php endif; ?>

           <?php if($content->paymenticon2[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->paymenticon2[$i], 'full' ) ?>
               <img class="pay-icon" src="<?=$img[0]?>"/>
           <?php endif; ?> 

           <!--END NEW CODE ICON-->   

       </div>
       <div class="dansk-licens xs-hide large-hide">
           <div class="abs-ipad">
           <?php if($content->logo_licence[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->logo_licence[$i], 'full' ) ?>
            <a href="<?= $content->company_link[$i] ?>" target="_blank"> <img class="aligncenter wp-image-1339 size-full" src="<?=$img[0]?>" ></a>
           <?php endif; ?>

           <!--NEW CODE ICON-->
           <?php if($content->paymenticon1[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->paymenticon1[$i], 'full' ) ?>
               <img class="pay-icon" src="<?=$img[0]?>"/>
           <?php endif; ?>

           <?php if($content->paymenticon2[$i]!=""): ?>
           <?php $img =  wp_get_attachment_image_src( $content->paymenticon2[$i], 'full' ) ?>
               <img class="pay-icon" src="<?=$img[0]?>"/>
           <?php endif; ?> 
           </div>
           <!--END NEW CODE ICON-->   

       </div>
       <div class="bono">
           <?php $btn_label = 'Jugar Ahora!'; if($content->link_button_label[$i]!="") {$btn_label =$content->link_button_label[$i]; } ?>
           <?php if($cnt==1): ?>
           <a class="pela" style="position:relative" href="<?= $content->company_link[$i] ?>" target="_blank" rel="attachment noopener wp-att-397"><?=$btn_label?>

               <?php if(isset($content->popup_text[$i]) && $content->popup_text[$i]!="") { ?>
                   <span class="popOverHolder">
                       <span class="popOver">
                           <?= $content->popup_text[$i]?>
                       </span>
                   </span>
               <?php } ?> 
           </a>
           <?php else: ?>
           <a class="pela" target="_blank" href="<?= $content->company_link[$i] ?>" rel="attachment noopener wp-att-397"><?=$btn_label?></a>
           <?php endif; ?>

           <p class="xs-hide">
                   <a title="<?=$content->company_name[$i]?>" href="<?= $content->company_link[$i] ?>" target="_blank" rel="noopener">
                       <span><?=$content->bono_text[$i]?></span>
                   </a>
               </p>

               <p class="small-hide">

                   <?php if($content->field1[$i]): $field_tag_counter++; ?>
                       <span class="text-box"><?=$content->field1[$i]?></span>
                   <?php endif; ?>
                   <?php if($content->field2[$i]): $field_tag_counter++; ?>
                       <span class="text-box"><?=$content->field2[$i]?></span>
                   <?php endif; ?>

                   <?php if($content->field3[$i]): $field_tag_counter++; ?>
                       <span class="text-box"><?=$content->field3[$i]?></span>
                   <?php endif; ?>
                    <?php if($content->field4[$i]): $field_tag_counter++; endif; ?>

                   <?php if($content->field4[$i]): ?>
                       <a title="<?=$content->company_name[$i]?>" href="<?= $content->field4link[$i] ?>" target="_blank" rel="noopener">
                           <span class="text-box"><?=$content->field4[$i]?></span>
                       </a>
                   <?php endif; ?>  
                  
                   <?php if($field_5_len > 0 && $field_5_len <= 10): ?>

                       <a title="<?=$content->company_name[$i]?>" href="<?= $content->field5link[$i] ?>" target="_blank" rel="noopener">
                           <span class="text-box"><?=$content->field5[$i]?></span>
                       </a>
                   <?php endif; ?>       
                   <!--    
                   <?php if($field_tag_counter < 4): ?>
                       <?php if($content->field4[$i]): ?>
                           <a title="<?=$content->company_name[$i]?>" href="<?= $content->field4link[$i] ?>" target="_blank" rel="noopener">
                               <span class="text-box"><?=$content->field4[$i]?></span>
                           </a>
                       <?php endif; ?> 
                   <?php endif; ?>    
                   -->
               </p>

       </div>    
       <div class="rating">               
               <span class="xs-hide"><div class="ratebox" data-id="1" data-rating="<?= $content->ratting[$i] ?>"></div></span>
               <p class="rating-btn">
                   <a href="<?= $content->review_link[$i] ?>" target="_blank"><span><?= $content->ratting_label[$i] ?></span></a>
               </p>  
               <!--
               <?php if($field_tag_counter > 3): ?>
               <p class="xs-hide small-hide" style="margin-top:60px;padding:0px 10px;">
                   <?php if($content->field4[$i]): ?>
                   <a title="<?=$content->company_name[$i]?>" href="<?= $content->field4link[$i] ?>" target="_blank" rel="noopener">
                       <span class="text-box"><?=$content->field4[$i]?></span>
                   </a>
                   <?php endif; ?>  
               </p>
               <?php endif; ?>  
               -->

       </div> 
       <div class="large-hide medium-hide">
           <div class="bono">
                   <p>
                       <a title="<?=$content->company_name[$i]?>" href="<?= $content->company_link[$i] ?>" target="_blank" rel="noopener">
                           <span><?=$content->bono_text[$i]?></span>
                       </a>
                   </p>
           </div>    
           <div class="rating">                           
                   <p class="large-hide medium-hide">
                       <?php if($content->field1[$i]): ?>
                           <span class="text-box"><?=$content->field1[$i]?></span>&nbsp;
                       <?php endif; ?>
                       <?php if($content->field2[$i]): ?>
                           <span class="text-box"><?=$content->field2[$i]?></span>&nbsp;
                       <?php endif; ?>

                       <?php if($content->field3[$i]): ?>
                           <span class="text-box"><?=$content->field3[$i]?></span>&nbsp;
                       <?php endif; ?>
                       <?php if($content->field4[$i]): ?>
                       <a title="<?=$content->company_name[$i]?>" href="<?= $content->field4link[$i] ?>" target="_blank" rel="noopener">
                           <span class="text-box"><?=$content->field4[$i]?></span>
                       </a>
                        <?php endif; ?>   
                   </p>                   
           </div> 
       </div>
   </div>
     <?php if($field_5_len > 0 && $field_5_len >= 10): ?>
    <div class="content_wrap">
        <div class="">
            <div class="bottom_text">
                <a title="<?=$content->company_name[$i]?>" href="<?= $content->field5link[$i] ?>" target="_blank" rel="noopener">
                    <span class="text-box"><?=$content->field5[$i]?></span>
                </a>
            </div>
            
        </div>
        
    </div>
    <?php endif; ?>   
</div> 
<?php } ?>
        <?php  } //else { echo "<br>". "Yes Find"; } ?>
<?php  }  ?>
<?php  } ?>


    

<script src="<?= PRD_PLUGIN_URL . '/public/js/raterater.jquery.js'?>"></script>
<script type="text/javascript">
jQuery(function($) {
    $( '.ratebox' ).raterater( { 
        starWidth: 20,
        spaceWidth: 4,
        numStars: 5,
        isStatic: true
    } );    
    setTimeout(function() {
       $(".popOverHolder").delay("slow").fadeIn();
    }, 2000);
    setTimeout(function() {
       $(".popOverHolder").delay("slow").fadeOut();
    }, 10000);
});
</script>
<?php endif ?>

