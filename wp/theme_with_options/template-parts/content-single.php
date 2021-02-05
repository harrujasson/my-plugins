<section class="container-fluid ap-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-4">
                <div class="inner">
                    <h1 class="hdng"><?php the_title();?></h1>
                </div>
            </div>

            <div class="col-md-12">
                <div class="inner singlePost featuredPost" <?php if ( has_post_thumbnail() ): ?>style="background-image: url(<?= the_post_thumbnail_url() ?>);" <?php else: ?>style="background-image: url(<?php bloginfo('template_url') ?>/assets/images/notfound.png);" <?php endif; ?>>
                    <ul>
                        <li>
                            <span class="date"><?= get_post_time('M d, Y'); ?></span>
                            <h3 class="hdng"><?php the_title();?>  </h3>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12 cntnt">
                <p>
                  <?php the_content();?>  
                </p>
            </div>
        </div>

        <div class="row mt-5 mb-5 otherPost">
            <div class="col-12">
                <h5 class="hdng"> Other Posts</h5>    
            </div>
            <?php 
                $the_query = new WP_Query( array(
                   'posts_per_page' => 3,
                )); 
            ?>
            <?php if ( $the_query->have_posts() ) : ?>
              <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="col-md-6 col-lg-4 mt-5">
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
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>

            <?php else : ?>
              <p><?php __('No Post'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>