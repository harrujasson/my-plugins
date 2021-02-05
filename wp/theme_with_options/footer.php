 <?php wp_footer(); ?>
 <div class="container-fluid mwpl-footer">
     <div class="container">
         <div class="row">
             <div class="col-12">
                 <div class="inner mwpl-footer-menu">
                    <?php wp_nav_menu( array( 
                        'theme_location' => 'menu-1',
                        'container' => false,
                        'items_wrap' => '<ul class="navbar-nav">%3$s</ul>',)); 
                    ?>
                 </div>
             </div>
         </div>
         <?php $footerIconDisp =  json_decode(getThemeInfo('mwplFooterIcons'));?>
         
         <?php if(!empty($footerIconDisp)): ?>
         
         <div class="row">
             <div class="col-12">
                 <div class="inner mwpl-footer-logos">
                     <ul>
                         <?php for($i=0;$i<count($footerIconDisp->icon);$i++): ?>
                         <li>
                             <a href="<?php echo esc_html( stripslashes( $footerIconDisp->link[$i] ) ); ?>">
                                 <img src="">
                                <?php if($footerIconDisp->icon[$i]!=""): ?>
                                <?php $img =  wp_get_attachment_image_src( $footerIconDisp->icon[$i], 'thumbnail' ) ?>
                                    <img src="<?=$img[0]?>" class="imgthumb">
                                <?php endif; ?>
                             </a>
                         </li>
                         <?php endfor; ?>
                         
                     </ul>
                 </div>
             </div>
         </div>
         <?php endif; ?>

         <div class="row">
             <div class="col-12">
                 <div class="inner mwpl-footer-copyrights">
                     <p>
                         Copyright &#169; <?=date('Y')?> - <?=   stripslashes(getThemeInfo('footerCopyright'))?>
                     </p>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Optional JavaScript -->
 <!-- jQuery first, then Popper.js, then Bootstrap JS -->
 <?php if(is_front_page()):?>
 <script src="<?php bloginfo('template_url') ?>/assets/js/jquery-3.5.1.slim.min.js"></script>
 <?php endif ;?>
 <script src="<?php bloginfo('template_url') ?>/assets/js/popper.min.js"></script>
 <script src="<?php bloginfo('template_url') ?>/assets/js/bootstrap.min.js"></script>
 
 <!--Script Code-->
 <?= getThemeInfo('footerScriptCode')?>
 
 </body>

 </html>
