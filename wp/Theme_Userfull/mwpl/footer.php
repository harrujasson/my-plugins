 <?php wp_footer(); ?>
    <footer class="container-fluid" id="footer">
        <div class="container">
            <div class="footer-ribbon"> <span>Get in Touch</span> </div>
            <div class="row py-5 my-4">
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <a href="<?php echo home_url('/'); ?>"><img src="<?php bloginfo('template_url') ?>/images/logo-small.png" style="height:70px;"></a>
                    <p class="pr-1 mt-4">Keep up on our always evolving product features and technology. Enter your e-mail address and on our always evolving product features and technology. Enter your e-mail address and subscribe to our newsletter.</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <h5 class="text-3 mb-3">LATEST TWEETS</h5>
                    <div id="tweet" class="twitter" data-plugin-tweets="" data-plugin-options="{'username': 'oklerthemes', 'count': 2}">
                        <ul>
                            <li>
                                <span class="status"><i class="fab fa-twitter false"></i> If you have any suggestions for the next updates, let us know.</span>
                                <span class="meta"> <a href="#" target="_blank">10:05 AM Sep 18th</a></span>
                            </li>
                            <li>
                                <span class="status"><i class="fab fa-twitter false"></i> We have just updated new Destinations. Check the changelog for more information.</span>
                                <span class="meta"> <a href="#" target="_blank">10:04 AM Sep 18th</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                    <div class="contact-details">
                        <h5 class="text-3 mb-3">CONTACT US</h5>
                        <ul class="list ">
                            <li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i>
                                <p class="m-0">234 Street Name, City Name</p>
                            </li>
                            <li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i>
                                <p class="m-0"><a href="tel:<?= SITE_PHONE?> "><?= SITE_PHONE?> </a></p>
                            </li>
                            <li class="mb-1"><i class="far fa-envelope text-color-primary"></i>
                                <p class="m-0"><a href="mailto:<?=SITE_EMAIL?>"><?=SITE_EMAIL?></a></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <h5 class="text-3 mb-3">FOLLOW US</h5>
                    <ul class="social-icons">
                        <li><a href="<?=FB?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="<?=FB?>" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="<?=FB?>" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container py-2">
                <div class="row py-4">
                    <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                        <a href="<?php echo home_url('/'); ?>" class="logo pr-0 pr-lg-3">
                            <img alt="" src="<?php bloginfo('template_url') ?>/images/logo-small.png" class="opacity-5" height="33">
                        </a>
                    </div>
                    <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                        <p>&copy; Copyright 2019. All Rights Reserved.</p>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                        <nav id="sub-menu">
                            <ul>
                                <li><i class="fas fa-angle-right"></i><a href="<?= site_url()?>/contactos/" class="ml-1 text-decoration-none"> Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>       
</body>
<script src="<?php bloginfo('template_url') ?>/js/lib/jquery-2.2.4.min.js"> </script>
        

<script src="<?php bloginfo('template_url') ?>/js/lib/popper.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/lib/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/vendors.js"></script>


<script src="<?php bloginfo('template_url') ?>/js/rev/theme.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/lib/jquery.appear.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/rev/jquery.themepunch.tools.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/rev/jquery.themepunch.revolution.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/rev/theme.init.js"></script>
<script>
    new WOW().init();

    /*Country slider*/
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
    
    /*Customer Reviews*/
    $('#testiSlider').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        items: 1
    });
</script>
</html>
<div class="modal fade bd-example-modal-lg" id="getQuotation" tabindex="-1" role="dialog" aria-labelledby="getQuotation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Obter cota&ccedil;&atilde;o</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="post">
                    <?php echo do_shortcode('[contact-form-7 id="110" title="Request Quote"]')?>
                </form>
            </div>
        </div>
    </div>
</div>