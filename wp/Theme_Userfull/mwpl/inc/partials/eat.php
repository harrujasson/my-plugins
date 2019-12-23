<?php 
$cnt=1;
$bottom = array();
if(!empty($post_information)){
    foreach($post_information as $post){
       
        $content = array();
        $is_bottom=0;
        $record = $this->getMetavalue($post->ID, 'eat_information');
        if($record!=""){
            $content = json_decode($record);  
        }       
        $is_bottom = $this->getmetinfo($post->ID, 'bottom');         
        $notice = $this->getmetinfo($post->ID, 'notice');  
        $notice2 = $this->getmetinfo($post->ID, 'notice_second');
       
        ?>
        <?php if(!$is_bottom){ ?>
        
        <div class="row <?php if($cnt%2 == 0){echo "back-color-second flexChrist";}else{echo "back-color flexChrist";} ?>">
            <div class="col-lg-9 col-xs-12 ">
                <div class="menu-card">
                    <?php if($cnt == 1): ?>
                    <h2>SAMPLE MENU</h2>
                    <hr>
                    <?php endif; ?>
                    <div class="menu-items mrgn-top">
                      <?php for($i=1;$i<count($content->title);$i++){  ?>  
                       <?php if(!empty($content)){ ?>
                        <?php if($content->category[$i]!=""){ ?>
                        <h4 class="Kids"><?=$content->category[$i]?></h4>
                        <?php } ?>
                        <h5>
                        <?=$content->title[$i]?> 
                            &#163;<?=$content->price_1[$i]?>
                            <?php if($content->price_2[$i]!=""){ ?>
                            /&#163;<?=$content->price_2[$i]?>
                            <?php } ?>
                        
                        </h5>
                        <p><?=$content->description[$i]?></p>                       
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 padding-0">
                <div class="menu-card-right">
                    <div class="right-text">
                        <p><?= $notice?></p>
                        <h5><?= $notice2?></h5>
                    </div>
                    <p>
                        <?php $img_url = $this->getImageMWPL($post->ID); ?>
                        <?php if($img_url!=""): ?>
                            <img class="alignnone size-medium wp-image-177" src="<?=$img_url?>" alt="" width="100%" height="100%">
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <?php $cnt++; ?>
        <?php }else{ $bottom = $post; } ?>
    <?php
    }
}
?>
<?php if(!empty($bottom)): ?>
<div class="row ">
    <?php $img_url = $this->getImageMWPL($bottom->ID); ?>
    <div class="col-lg-12 back-img padding-0" style="background: url(<?=$img_url?>)">
        <div class="menu-overlay"></div>
        <?= $bottom->post_content ?>
    </div>
</div>
<?php endif; ?>

