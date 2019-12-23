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
        <?php else: ?>
        <?php the_content(); ?>
        <?php endif;  ?>
    </div>
</article>

