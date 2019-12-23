<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 */

?>

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

