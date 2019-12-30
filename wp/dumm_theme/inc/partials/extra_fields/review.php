<link href="<?=MWPL_PARTIALS_URL?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=MWPL_PARTIALS_URL?>css/style.css" rel="stylesheet">
<div class="wrap">
    <div class="form-container">
        <div class="form-group mb10">                                            
            <label class="col-lg-2">Name: </label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="client_review[name]" value="<?=$name?>">
            </div>
        </div>
        <div class="form-group mb10">                                            
            <label class="col-lg-2">Designation: </label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="client_review[designation]" value="<?=$designation?>">
            </div>
        </div>
        <div class="form-group mb10">                                            
            <label class="col-lg-2">Comment: </label>
            <div class="col-lg-10">                       
                <textarea class="form-control" name="client_review[comment]"><?=$comment?></textarea>
            </div>
        </div>
        
    </div>
</div>