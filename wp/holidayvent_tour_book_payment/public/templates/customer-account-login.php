<?php 
/*
 * Template Name: MWPL Customer Login
 */

?>

<?php

get_header(); ?>
<!-- Bootstrap core CSS -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:300i,400,400i,500,500i,700&display=swap" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_PUBLIC?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_PUBLIC?>font-awesome/fontawesome.css" rel="stylesheet" type="text/css">
<link href="<?=PRD_PLUGIN_URL_PUBLIC?>css/style.css" rel="stylesheet">

 <div class="mainBody-ap">
    <div class="container-fluid loginPage pt-4 pb-4">
        <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
                    the_post(); ?>

        <div class="container">
            <div class="row d-flex justify-content-center align-items-center holder">
                <div class="col-12 col-sm-10 col-md-9">
                    <div class="row shadowHolder">
                        <div class="col-12 col-lg-6 col-xl-6 left">
                            <!--/****  Background Area *****/-->
                            <div class="login"></div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6 right">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <?php
            endwhile;
    endif;
    ?> 
    </div>
 </div>

<?php
get_footer(); ?>
<script src="<?=PRD_PLUGIN_URL_PUBLIC?>js/popper.min.js"></script>
<script type="text/javascript" src="<?=PRD_PLUGIN_URL_PUBLIC?>js/bootstrap.min.js"></script>
