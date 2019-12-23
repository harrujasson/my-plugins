<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/ *

 */
get_header();
?>

<?php

if ( have_posts() ) :
    
        /* Start the Loop */
        while ( have_posts() ) :  
   
          the_post();
          get_template_part( 'template-parts/content', 'page' );
                

        endwhile;
else :
echo "Hello";
        get_template_part( 'template-parts/content', 'none' );

endif;
?>
<?php
//get_sidebar();
get_footer(); ?>

	