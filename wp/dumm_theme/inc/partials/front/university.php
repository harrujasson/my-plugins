<?php if(!empty($record)): ?>
<div class="container-fluid travelPackages">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="inner">
                    <h2>Tours And Fun Destinations</h2>
                    <span class="subHdng">Are you interested in finding out how we can make your project a success? Please constact us.</span>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <?php foreach($record as $r): $image = $this->getImageMWPL($r->ID,'original'); ?>
            <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 mt-5">
                <div class="inner sliderBox">
                    <div class="figure">
                        <img src="<?=$image;?>" class="w-100">
                    </div>
                    <div class="cntnt">
                        <h5>
                            <span class="countryName"><?= $r->post_title?></span>
                        </h5>

                        <p class="rating"><i class="fas fa-map-marker-alt"></i> <strong><?=$this->getmetinfo($r->ID,'university_country')?></strong></p>

                        <p class="text">
                           <?= split_content($r->post_content, 100); ?>  
                        </p>
                    </div>

                    <div class="completeDesc">
                        <p>
                            <a href="<?php echo get_permalink($r->ID);?>">Explore University</a>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>

        <div class="row mt-5 paginationApp">
            <div class="col-12">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
