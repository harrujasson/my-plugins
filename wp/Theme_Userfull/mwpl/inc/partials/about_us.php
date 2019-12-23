<?php 
if(!empty($post_information)){    
    $cnt=0;
    $inc =0;
    $bottom_content = array();
    $record = $this->getMetavalue($post_information->ID, 'about_information');  
    
    if($record!=""){
        $content = json_decode($record);   
        //echo "<pre>";  print_r($content); echo "</pre>"; die();
    for($i=1;$i<count($content->description);$i++){      
        if($content->bottom[$i] == "0"){ ?>
        
        <?php if($inc%2 ==0): ?>
            

            <div class="row about-us ">
                <div class="col-md-6 col-xs-12 about-padding dFlex alignItemsCenter">
                    <div class="about-inner">
                        <?php if($cnt ==0){ $cnt++; ?>
                        <h2>ABOUT US</h2>
                        <?php } ?>
                        <p><?= $content->description[$i] ?></p>

                    </div>
                </div>
                <div class="col-md-6 col-xs-12 about-padding-0">
                    <div class="about-img">
                        <?php if($content->picture[$i]!=""): ?>
                            <?php $img =  wp_get_attachment_image_src( $content->picture[$i], 'large' ) ?>
                                <img src="<?=$img[0]?>" class="imgthumb">
                        <?php endif; ?>>
                    </div>
                </div>
            </div>

            <?php else: ?>
            <div class="row about-us reverseDirectionTab">
                <div class="col-md-6 col-xs-12 about-padding-0">
                    <div class="about-img">                        
                        <?php if($content->picture[$i]!=""): ?>
                            <?php $img =  wp_get_attachment_image_src( $content->picture[$i], 'large' ) ?>
                                <img src="<?=$img[0]?>" class="imgthumb">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 about-padding dFlex alignItemsCenter">
                    <div class="about-inner">
                        <p><?= $content->description[$i] ?></p>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php } else{ ?>
            <div class="row about-us">
                <div class="col-md-12 col-xs-12 about-padding-0">
                    <?php $img_url[0] =''; ?>
                    <?php if($content->picture[$i]!=""): ?>
                    <?php $img_url =  wp_get_attachment_image_src( $content->picture[$i], 'large' ) ?>
                    <?php endif; ?>
                    
                    <div class="about-img-4 aboutTextAlign" style="background: url(<?=$img_url[0]?>)">
                        <div class="about-text">
                            <h1><?= $content->title[$i] ?></h1>  
                            <p><?= $content->description[$i] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php $inc++; 
    } 
    }?>


<?php
}
?>
