<?php 
get_header();
?>
<?php

    /* Start the Loop */
    while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', get_post_format() );
    endwhile; // End of the loop.
?>
<?php get_footer(); ?>