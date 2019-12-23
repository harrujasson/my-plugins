<?php
/*
 * Template Name: Eat
 */
get_header();

?>

<?php 
if ( have_posts() ) :
    
        /* Start the Loop */
        while ( have_posts() ) :  
   
          the_post();
         the_content();		
               $cpt_obj->eat_information_plugin(get_the_ID()); 

        endwhile;
else :
echo "Hello";
        get_template_part( 'template-parts/content', 'none' );

endif;

?>
<?php get_footer(); ?>
