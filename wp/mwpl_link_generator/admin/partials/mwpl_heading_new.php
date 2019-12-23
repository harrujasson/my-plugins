<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<?php wp_enqueue_media(); ?>
<div class="wrap">
    <div class="container" >
        <h2>New  - Heading</h2> 
        
            <div class="row">
                <div class="form-container">
                    <form method="post" action="#"> 
                        
                        <?php if(isset($_GET['status']) && $_GET['status']  == "error"): ?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&#120;</a>
                                <strong>Error!</strong> Something went wrong.Please try after some time.
                            </div>
                        <?php endif; ?>
                                                          
                            <div class="form-group html_content">           
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <?php $cnt=1; for($i=0;$i<=4;$i++){ ?>
                                            <div class="form-group">                                            
                                                <label class="col-lg-2">Heading <?=$cnt?>: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[]"  required="">
                                                </div>
                                            </div> 
                                        <?php $cnt++; } ?>
                                    </div>
                                </div>
                            </div>
                                            
                        
                        <div class="form-group">
                            <div class="col-lg-12">
                            <div class="button_container">                                
                                <input type="submit" class="btn btn-primary" value="Save" name="new_request_heading">                                
                            </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
       
        </div>
</div>
