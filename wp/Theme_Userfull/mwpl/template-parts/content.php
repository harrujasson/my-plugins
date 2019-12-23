<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

?> 
<article id="post-<?php the_ID(); ?>" class="post post-large">  
    <div class="post-content"> 
        
        <?php if(!is_singular()): ?>
        <p><?php $content = get_the_content(); echo substr(strip_tags($content), 0, 400).'...';?></p>
        <p>testing university</p>
        <?php else: ?>
        <?php 
            if(!is_front_page()){
            $banner_image = get_image_featured(get_the_ID());
            $country = get_meta_info(get_the_ID(), 'university_country');
            $package = get_meta_info(get_the_ID(), 'travel_package_country');
            if(empty($banner_image)): ?>
            <div class="container-fluid breadCrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <div class="inner">
                                <h3><?php the_title()?></h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="inner">
                                <ul>
                                    <li>
                                        <a href="<?= home_url()?>">Home</a>
                                    </li>
                                    <li>
                                        <span><?php the_title()?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php  else: ?>
            <div class="container-fluid packageBanner" style="background-image:url(<?=$banner_image?>)">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner">

                                <div class="breadCrumbs">
                                    <ul>
                                        <li>
                                            <a href="<?= home_url()?>">Home</a>
                                        </li>
                                        <li>
                                            <span><?php the_title()?></span>
                                        </li>
                                    </ul>
                                </div>
                                <h1><?php the_title()?> </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php  endif; ?>
        <?php } ?>
        <div class="container-fluid travelPackages single">
            <div class="container">
                <div class="row mt-1 d-flex justify-content-center">
                    <div class="col-12 col-sm-11 col-md-11 col-lg-10 col-xl-10 mt-5">
                        <div class="inner sliderBox">
                            <div class="figure">
                            <img src="<?=$banner_image?>" class="w-100">
                            </div>
                            <div class="cntnt">
                                <h3>
                                    <span class="countryName"> <i class="fas fa-map-marker-alt active_color"></i> <?= $country?><?= $package?></span>
                                    <span class="price"></span>
                                </h3>

                                <p class="text">
                                   <?php the_content(); ?>  
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 paginationApp">
                    <div class="col-12 text-center">
                        <?php previous_post_link(); ?> 
                                     
                        <?php next_post_link(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;  ?>
    </div>
</article>