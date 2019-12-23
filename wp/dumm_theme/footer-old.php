 
<?php wp_footer(); ?>
 <?PHP $section1 = get_post(134);  ?>
<?PHP $section2 = get_post(135);  ?>
<?PHP $section3 = get_post(136);  ?>
<footer>
    <div class="container">
            <div class="row">
                    <div class="col-md-6 col-sm-6">
                       <?=$section1->post_content?>    
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <?=$section2->post_content?>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <?=$section3->post_content?>
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
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html>
