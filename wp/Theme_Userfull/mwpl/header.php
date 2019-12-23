<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php wp_title('', true,''); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" href="<?php bloginfo('template_url') ?>/images/fav-icon.png">
    <link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/images/fav-icon.ico">

    <!-- Google Font (font-family: 'Montserrat', sans-serif;) -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <!-- Google Font (font-family: 'Raleway', sans-serif;) -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <!-- Google Font (font-family: "Shadows Into Light", cursive;) -->
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap" rel="stylesheet">

    <!------- bootstrap -------------->
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/bootstrap/bootstrap.min.css">
    <!----------  main css ------------->
    <link href="<?php bloginfo('template_url') ?>/css/style.css" rel="stylesheet" type="text/css">
    <!------- bootstrap -------------->
    
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/vendors/all-vendors.css">
    
    
    <?php wp_head(); ?>
</head>

<body class="position-relative">
    <!--- whatsapp scroll btn --->
    <div class="whatsAppBtn">
        <a href="https://wa.me/447566710740">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
    <!--- whatsapp scroll btn --->
    <!------- header and top bar ------>
    <div class="container-fluid topBar">
        <div class="container">
            <div class="row">
                <div class="col-md-8 d-none d-md-block">
                    <div class="inner">
                        <p>
                            <!--
                            <a href="#">
                                <i class="fas fa-home"></i>
                                <span>4946 Marmora Road, Central New</span>
                            </a>
-->

                            <a href="tel:<?= SITE_PHONE?>">
                                <i class="fas fa-phone"></i>
                                <span> <?= SITE_PHONE?></span>
                            </a>

                            <a href="https://wa.me/<?=SITE_WHATSUP?>">
                                <i class="fab fa-whatsapp"></i>
                                <span> <?=SITE_WHATSUP?></span>
                            </a>

                            <a href="#">
                                <i class="far fa-clock"></i>
                                <span>Mon-Sat: 8am - 6pm</span>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 social  text-md-right">
                    <div class="inner">
                        <p>
                            <a href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <a href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <span><?php echo do_shortcode('[gtranslate]'); ?></span>
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid header position-sticky" style="top: 0px;z-index: 999;background: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner">
                        <nav class="navbar navbar-expand-lg navbar-light p-lg-0">
                            <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
                                <img src="<?php bloginfo('template_url') ?>/images/logo-small.png">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse d-lg-flex justify-content-end" id="navbarSupportedContent">
                                <?php
                                    wp_nav_menu( array(
                                    'theme_location' => 'menu-1',
                                    'container'       => 'ul',                                                                                                             
                                    'menu_id'        => 'mainNav',
                                    'menu_class'        => 'nav navbar-nav',
                                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    ) );
                                ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
  