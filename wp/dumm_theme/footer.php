 
<?php wp_footer(); ?>
 <?PHP $section1 = get_post(134);  ?>
<?PHP $section2 = get_post(135);  ?>
<?PHP $section3 = get_post(136);  ?>
<footer>
    <div class="container">
            <div class="row">
                    <div class="col-md-5 col-sm-6">
                       <?=$section1->post_content?>    
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <?=$section2->post_content?>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <?=$section3->post_content?>
                    </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="social ftrSocial">
                    <a href="https://twitter.com/durantarms"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/thedurantarms"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/durantarms"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <br/>
                    <a href="http://durant.initialdesign.co.uk/"><img src="http://durant.initialdesign.co.uk/wp-content/themes/mwpl/img/logo2.PNG"></a>
                </div>
                </div>
            </div>
    </div>
</footer>
<div class="copyright">
        <div class="container">
                <div class="row">
                        <div class="col-md-12">
                                <p>&copy; Copyright 2019 The Durant Arms | Privacy Policy | </p>
                        </div>
                </div>
        </div>
</div>          
<!--Main container-->
</div>
<!--side-body-->
</div>
</div>
</div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$(".down").click(function() {
     $('html, body').animate({
         scrollTop: $(".copyright").offset().top
     }, 2500);
 });
});
</script>
</html>
