<?php if(!empty($record)): ?>
<div class="container-fluid countrySlider sectionHdngs">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="inner">
                        <h2>Coisas Cool & publicidade</h2>
                        <span class="subHdng">Are you interested in finding out how we can make your project a success? Please constact us.</span>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="owl-carousel owl-theme text-center" id="countrySlider">
                        <?php foreach($record as $r): $image = $this->getImageMWPL($r->ID,'Orginal');?>
                        <div class="item">
                            <div class="row">
                                <div class="col-12 p-4">
                                    <img src="<?=$image;?>" class="h-100">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
$('#countrySlider').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            991: {
                items: 4
            },
            1199: {
                items: 5
            }
        }
    });
</script>
<?php endif; ?>

