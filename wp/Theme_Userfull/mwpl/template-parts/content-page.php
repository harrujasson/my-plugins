<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 */
?>
<?php 
if(!is_front_page()){
$banner_image = get_image_featured(get_the_ID());
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

        <?php
        
        the_content();		
        ?>
	
        
	<?php if ( get_edit_post_link() ) : ?>
        <div class="post-meta">
		
            <?php
            edit_post_link(
                    sprintf(
                            wp_kses(
                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                    __( 'Edit <span class="screen-reader-text">%s</span>', 'ashs' ),
                                    array(
                                            'span' => array(
                                                    'class' => array(),
                                            ),
                                    )
                            ),
                            get_the_title()
                    ),
                    '<span class="edit-link"><i class="fas fa-pencil"></i>',
                    '</span>'
            );
            ?>
		
        </div>
	<?php endif; ?>

