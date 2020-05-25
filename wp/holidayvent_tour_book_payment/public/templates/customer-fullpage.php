<?php 
/*
 * Template Name: MWPL Customer FullPage
 */
get_header();
?>

<!-- Bootstrap core CSS -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:300i,400,400i,500,500i,700&display=swap" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_PUBLIC?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_PUBLIC?>font-awesome/fontawesome.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="<?=PRD_PLUGIN_URL_PUBLIC?>css/style.css" rel="stylesheet">

 <div class="mainBody-ap">
    <div class="container-fluid paymentPage">
        <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
                    the_post(); ?>
        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <?php the_content(); ?>
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

<script type="text/javascript" src="<?=PRD_PLUGIN_URL_PUBLIC?>js/bootstrap.min.js"></script>
<script src="<?=PRD_PLUGIN_URL_PUBLIC?>js/popper.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=PRD_PLUGIN_URL_PUBLIC?>js/custom.js"></script>

