<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 */

?>
<section class="container-fluid ap-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-4">
                <div class="inner">
                    <h1 class="hdng">Blog</h1>
                </div>
            </div>
            <?php $cnt=0; while(have_posts()) :  the_post(); ?>
            <?php if($cnt==0):  ?>
            <div class="col-md-12">
                <div class="inner featuredPost" <?php if ( has_post_thumbnail() ): ?>style="background-image: url(<?= the_post_thumbnail_url() ?>);" <?php else: ?>style="background-image: url(<?php bloginfo('template_url') ?>/assets/images/notfound.png);" <?php endif; ?>>
                    <ul>
                        <li>
                            <span class="date"><?= get_post_time('M d, Y'); ?></span>
                            <h3 class="hdng"><?php the_title(); ?></h3>
                        </li>
                        <li>
                            <a href="<?php the_permalink() ?>">Read </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="col-md-6 col-lg-4 mt-5 mb-5 otherPost">
                <div class="inner featuredPost" <?php if ( has_post_thumbnail() ): ?>style="background-image: url(<?= the_post_thumbnail_url() ?>);" <?php else: ?>style="background-image: url(<?php bloginfo('template_url') ?>/assets/images/notfound.png);" <?php endif; ?>>
                    <ul>
                        <li>
                            <span class="date"><?= get_post_time('M d, Y'); ?></span>
                            <h3 class="hdng"><?php echo mb_strimwidth(get_the_title(), 0, 40, '...'); ?></h3>
                        </li>
                        <li>
                            <a href="<?php the_permalink() ?>">Read </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php $cnt++; endwhile; ?>
        </div>
        
        <div class="row mt-5 paginationApp">
            <div class="col-12 text-center">
                <?php previous_post_link(); ?> 

                <?php next_post_link(); ?>
            </div>
        </div>
        
    </div>
</section>
