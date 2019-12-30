<?php if(!empty($record)): ?>

<div class="container-fluid mapSection sectionHdngs">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 text-center">
                <div class="inner">
                    <h2>O que dizem os nossos clientes</h2>
                    <span class="subHdng">A GB Solutions importa-se com a opinião dos seus clientes, acreditando que só assim manterão a satisfação desejada por eles.</span>
                </div>
            </div>
            <div class="col-md-9 col-lg-8 col-xl-7 pt-5 pb-5 mapInnerSection">
                <div class="owl-carousel owl-theme text-center" id="testiSlider">
                    <?php foreach($record as $r): $image = $this->getImageMWPL($r->ID,'Orginal'); ?>
                    <div class="item">
                        <div class="row">
                            <div class="col-12 pt-4 pb-4">
                                <div class="inner testiBox">
                                    <p>
                                        <?=$this->getmetinfo($r->ID,'client_review_comment')?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-12 mt-1">
                                <div class="inner infoBox">
                                    <ul>
                                        <li>
                                            <img src="<?=$image;?>" class="w-100">
                                        </li>
                                        <li>
                                            <p><?=$this->getmetinfo($r->ID,'client_review_name')?></p>
                                            <span><?=$this->getmetinfo($r->ID,'client_review_designation')?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                 <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
