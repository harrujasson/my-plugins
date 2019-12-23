<?php 
if(!empty($rooms)){
    $inc = 0;
    foreach ($rooms as $r){ 
        ?>
<div class="col-lg-12 col-xs-12 p-0 back-clor">
    <div class="row stayRow">
    <?php if($inc%2 ==0): ?>
    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 padding-left-0 padding-right-0 fst-room">
        <div id="carousel-example-generic_<?=$r->ID?>" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <!-- Wrapper for slides -->

            <div class="carousel-inner" role="listbox">
                <?php $cnt=0; foreach($this->getmetinfo($r->ID,'_pods_gallery') as $gallery){
                            $info =  wp_get_attachment_image_src($gallery,'large'); ?>
                <div class="item <?php if($cnt==0){echo 'active';}?>">
                    <img src="<?=$info[0]?>" alt="..." class="img-responsive">
                    <div class="carousel-caption">
                    </div>
                </div>
                <?php $cnt++;} ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic_<?=$r->ID?>" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic_<?=$r->ID?>" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 padding-left-0 padding-right-0">
        <div class="fst-right">
            <h2><span>&#60; </span><?=$r->post_title?></h2>
            <h5><?=$this->getmetinfo($r->ID,'sub_title');?></h5>
            <?= $r->post_content; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 padding-left-0 padding-right-0">
        <div class="fst-right">
            <h2><?=$r->post_title?><span> &#62;</span></h2>
            <h5><?=$this->getmetinfo($r->ID,'sub_title');?></h5>
            <?= $r->post_content; ?>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 padding-left-0 padding-right-0 fst-room">
        <div id="carousel-example-generic_<?=$r->ID?>" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php $cnt=0; foreach($this->getmetinfo($r->ID,'_pods_gallery') as $gallery){
                            $info =  wp_get_attachment_image_src($gallery,'large'); ?>
                <div class="item <?php if($cnt==0){echo 'active';}?>">
                    <img src="<?=$info[0]?>" alt="..." class="img-responsive">
                    <div class="carousel-caption">
                    </div>
                </div>
                <?php $cnt++;} ?>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic_<?=$r->ID?>" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic_<?=$r->ID?>" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <?php endif; ?>
    </div>
</div>
<?php
     $inc++;
}
}
?>
