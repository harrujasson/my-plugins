<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/assets/img/favicon.ico" type="image/x-icon" />        

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">       
        <!-- Theme Custom CSS -->
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	        
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<?php wp_head(); ?>
</head>

<body>
    
<!--<div class="header">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-12 text-center header-font">-->
<!--                <p><span>Tel:</span> <a href="tel:<?=SITE_PHONE?>"><?=SITE_PHONE?></a></p>-->
<!--                <p><span>Email:</span> <a href="mailto:<?=SITE_EMAIL?>"><?=SITE_EMAIL?></a></p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div> -->
<div class="container-fluid">
    <div class="row side-back-color">
        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 p-0">
            <div class="side-menu">
            <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    
                    <div class="row" style="display:flex;">
                            <div class="col-xs-3 col-md-12 col-sm-12">
                                <a class="navbar-brand" href="<?= site_url('/')?>">
                                    <img src="<?php bloginfo('template_url') ?>/img/logo-durant.png">
                                </a>
                            </div>
                            <div class="col-xs-7 logoHolder mobile-view">
                                <span class="logo-text">DURANT ARMS</span>
                            </div>
                            <div class="col-xs-2 mobile-menu">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                    </div>
                </div>

                <!-- Main Menu -->
                <div class="side-menu-container">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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
                </div><!-- /.navbar-collapse -->

                <div class="social">
                    <a href="<?=TW?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="<?=FB?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="<?=INSTA?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="<?= site_url('/')?>"><img src="<?php bloginfo('template_url') ?>/img/logo2.PNG"></a>
                </div>

            </nav>
            </div>
    </div>
<!-- Main Content -->
    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12 p-0">
        <div class="side-body">    