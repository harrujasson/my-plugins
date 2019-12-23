<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>

<link rel='stylesheet' type='text/css' href='<?= PRD_PLUGIN_URL.'/admin/form-select2/select2.css'?>' />
<script type='text/javascript' src='<?= PRD_PLUGIN_URL.'/admin/form-select2/select2.min.js'?>'></script> 

<script src="<?=PRD_ADMIN_URL?>colorpicker/jquery.colorpicker.js"></script>
<link href="<?=PRD_ADMIN_URL?>colorpicker/jquery.colorpicker.css" rel="stylesheet" type="text/css"/>

<?php wp_enqueue_media(); ?>
<div class="wrap">
    <div class="container" >
        <form method="post" action="#"> 
        <h2>Edit  <?= ' '.get_the_title( $record->page_id ); ?></h2> 
        <input type="submit" class="btn btn-primary" value="Save" name="update_request">     
        
            <div class="row">
                
                
                <div class="form-container" id="container_form">
                    
                    <!--Page heading logos-->
                    <div class="form-group html_content">           
                        <div class="panel panel-default"> 
                            <div class="panel-heading" >
                                <h1>Page Content Text/Logo</h1>
                            </div>
                            <div class="panel-body" >  
                                
                                <?php if($record->content!=""): ?>
                                <?php $contentraw_head = json_decode($record->content); 
                                $content_head = $contentraw_head->data;
                                //echo "<pre>"; print_r($record->content); echo "</pre>"; die();
                                ?>
                                <div class="form-group" style="display:none">
                                    <label class="col-lg-2">Text: </label>
                                    <div class="col-lg-3">                                        
                                        <input type="text" name="data[head_text][]" value="" class="form-control">                                                 
                                    </div>

                                    <label class="col-lg-2">Picture: </label>
                                    <div class="col-lg-3">
                                        <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp;                                         
                                        <input type="hidden" name="data[head_picture][]" value="" class="custom-img-id">                                                 
                                    </div>
                                </div>
                                <?php $head_cnt=1; for($h=0;$h<=3;$h++){ ?>
                                
                                <div class="form-group">
                                    <label class="col-lg-2">Text - <?=$head_cnt?>: </label>
                                    <div class="col-lg-3">                                        
                                        <input type="text" name="data[head_text][]" value="<?= $content_head->head_text[$h] ?>" class="form-control">                                                 
                                    </div>

                                    <label class="col-lg-2">Picture: </label>
                                    <div class="col-lg-3">
                                        <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                        <input type="button" class="btn btn-danger delete-custom-img <?php if($content_head->head_picture[$h] ==""){echo "hidden";} ?>" value="Delete">
                                        <div class="m-t-10 custom-img-container">
                                            <?php if($content_head->head_picture[$h]!=""): ?>
                                            <?php $img =  wp_get_attachment_image_src( $content_head->head_picture[$h], 'thumbnail' ) ?>
                                                <img src="<?=$img[0]?>" class="imgthumb">
                                            <?php endif; ?>
                                        </div> 
                                        <input type="hidden" name="data[head_picture][]" value="<?= $content_head->head_picture[$h] ?>" class="custom-img-id">                                                 
                                    </div>
                                </div>
                               
                                <?php $head_cnt++; } ?>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                    <!--End page heading logos-->
                        
                        <div id="pre_loaded_html" style="display: none;">
                            <div class="form-group html_content" >           
                                <div class="panel panel-default">
                                    <div class="panel-heading" >
                                        <div class="button_remove col-lg-2">
                                            <a href="javascript:void(0)" class="remove_container" >Remove</a>
                                        </div>                                        
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#sortable" href="#three">Expand </a>                                        
                                    </div>
                                    <div class="panel-collapse collapse" id="three">
                                        
                                        <div class="panel-body">
                                        
                                            <div class="form-group">                                            
                                                <label class="col-lg-2">Link: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[company_link][]">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">Brand Name: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[company_name][]">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Bonus Text: </label>
                                                <div class="col-lg-8">                                                
                                                    <textarea class="form-control" name="data[bono_text][]" rows="10"></textarea>
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-lg-2">Link Button Label: </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="data[link_button_label][]">
                                                    </div>                                            
                                                </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Brand Logo: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img hidden" value="Delete">
                                                    <div class="m-t-10 custom-img-container"></div>
                                                    <input type="hidden" name="data[logo][]" class="custom-img-id">                                                 
                                                </div>

                                                <label class="col-lg-2">License Icon: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img hidden" value="Delete">
                                                    <div class="m-t-10 custom-img-container"></div>
                                                    <input type="hidden" name="data[logo_licence][]" class="custom-img-id">                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Payment 1 Icon: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img hidden" value="Delete">
                                                    <div class="m-t-10 custom-img-container"></div>
                                                    <input type="hidden" name="data[paymenticon1][]" class="custom-img-id">                                                 
                                                </div>

                                                <label class="col-lg-2">Payment 2 Icon: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img hidden" value="Delete">
                                                    <div class="m-t-10 custom-img-container"></div>
                                                    <input type="hidden" name="data[paymenticon2][]" class="custom-img-id">                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Rating Label: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[ratting_label][]">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Rating: </label>
                                                <div class="col-lg-3">
                                                    <input type="number" max="5"  min="0" step="any" class="form-control" name="data[ratting][]">
                                                </div>
                                                <label class="col-lg-2">Review Link: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[review_link][]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 1: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field1][]">
                                                </div>
                                                <label class="col-lg-2">Field 2: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[field2][]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 3: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field3][]">
                                                </div>
                                                <label class="col-lg-2">Field 4: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[field4][]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 4 Link: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field4link][]">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 5: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field5][]">
                                                </div>
                                                <label class="col-lg-2">Field 5 Link: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[field5link][]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Hide: </label>
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="data[show][]">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select> 
                                                </div>                                            
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Ribbon Text: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[ribbon_text][]" autocomplete="off">
                                                </div>                                                 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3">Ribbon Background Color: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control cp-color inptSet" name="data[ribbon_bg][]" value="56dd35" autocomplete="off">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3">Ribbon Text Color: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control cp-color inptSet" name="data[ribbon_text_color][]" value="f8f4f4" autocomplete="off">
                                                </div>                                            
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Pop-Up Text: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[popup_text][]"  autocomplete="off">
                                                </div>                                                 
                                            </div>

                                            <?php if($page_id ==0): ?>
                                                <div class="form-group">
                                                    <label class="col-lg-2">Exclude Page: </label>
                                                    <div class="col-lg-10"> 
                                                        <input type="hidden" class="e12" style="width:100%" name="data[exclude_page][]" />

                                                    </div>                                            
                                                </div>
                                            <?php endif ?>

                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="load_html" id='sortable'>
                            <?php if($record->content!=""): ?>
                            <?php $contentraw = json_decode($record->content); 
                            $content = $contentraw->data;
                            ?>
                            <?php for($i=0;$i<count($content->company_name);$i++){?>
                                <div class="form-group html_content">           
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="button_remove col-lg-2">
                                                <a href="javascript:void(0)" class="remove_container" >Remove</a>
                                            </div>                                            
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#sortable" href="#accord_<?=$i?>"> Expand #<?= $content->company_name[$i] ?> </a>

                                        </div>
                                        <div class="panel-collapse collapse" id="accord_<?=$i?>">
                                        <div class="panel-body" >
                                            
                                            <div class="form-group">                                            
                                                <label class="col-lg-2">Link: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[company_link][]" value="<?= $content->company_link[$i] ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Brand Name: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[company_name][]" value="<?= $content->company_name[$i] ?>">
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Bonus Text: </label>
                                                <div class="col-lg-8">                                                
                                                    <textarea class="form-control" name="data[bono_text][]" rows="10"><?= $content->bono_text[$i] ?></textarea>
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Link Button Label: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[link_button_label][]" value="<?= $content->link_button_label[$i] ?>">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Brand Logo: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img <?php if($content->logo[$i] ==""){echo "hidden";} ?>" value="Delete">
                                                    <div class="m-t-10 custom-img-container">
                                                        <?php if($content->logo[$i]!=""): ?>
                                                        <?php $img =  wp_get_attachment_image_src( $content->logo[$i], 'thumbnail' ) ?>
                                                            <img src="<?=$img[0]?>" class="imgthumb">
                                                        <?php endif; ?>
                                                    </div> 
                                                    <input type="hidden" name="data[logo][]" value="<?= $content->logo[$i] ?>" class="custom-img-id">                                                 
                                                </div>
                                                
                                                <label class="col-lg-2">License Icon: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img <?php if($content->logo_licence[$i] ==""){echo "hidden";} ?>" value="Delete">
                                                    <div class="m-t-10 custom-img-container">
                                                        <?php if($content->logo_licence[$i]!=""): ?>
                                                        <?php $img =  wp_get_attachment_image_src( $content->logo_licence[$i], 'thumbnail' ) ?>
                                                            <img src="<?=$img[0]?>" class="imgthumb">
                                                        <?php endif; ?>
                                                    </div> 
                                                    <input type="hidden" name="data[logo_licence][]" value="<?= $content->logo_licence[$i] ?>" class="custom-img-id">                                                 
                                                </div>
                                                
                                                
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Payment 1 Icon: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img <?php if($content->paymenticon1[$i] ==""){echo "hidden";} ?>" value="Delete">
                                                    <div class="m-t-10 custom-img-container">
                                                        <?php if($content->paymenticon1[$i]!=""): ?>
                                                        <?php $img =  wp_get_attachment_image_src( $content->paymenticon1[$i], 'thumbnail' ) ?>
                                                            <img src="<?=$img[0]?>" class="imgthumb">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="hidden" name="data[paymenticon1][]" class="custom-img-id" value="<?= $content->paymenticon1[$i] ?>">                                                 
                                                </div>

                                                <label class="col-lg-2">Payment 2 Icon: </label>
                                                <div class="col-lg-3">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img <?php if($content->paymenticon2[$i] ==""){echo "hidden";} ?>" value="Delete">
                                                    <div class="m-t-10 custom-img-container">
                                                        <?php if($content->paymenticon2[$i]!=""): ?>
                                                        <?php $img =  wp_get_attachment_image_src( $content->paymenticon2[$i], 'thumbnail' ) ?>
                                                            <img src="<?=$img[0]?>" class="imgthumb">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="hidden" name="data[paymenticon2][]" class="custom-img-id" value="<?= $content->paymenticon2[$i] ?>">                                                 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Rating Label: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[ratting_label][]" value="<?= $content->ratting_label[$i] ?>">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Rating: </label>
                                                <div class="col-lg-3">
                                                    <input type="number" max="5"  min="0" step="any" class="form-control" name="data[ratting][]" value="<?= $content->ratting[$i] ?>">
                                                </div>
                                                <label class="col-lg-2">Review Link: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[review_link][]" value="<?= $content->review_link[$i] ?>">
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 1: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field1][]" value="<?= $content->field1[$i] ?>">
                                                </div>
                                                <label class="col-lg-2">Field 2: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[field2][]" value="<?= $content->field2[$i] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 3: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field3][]" value="<?= $content->field3[$i] ?>">
                                                </div>
                                                <label class="col-lg-2">Field 4: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[field4][]" value="<?= $content->field4[$i] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 4 Link: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field4link][]" value="<?= $content->field4link[$i] ?>">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Field 5: </label>
                                                <div class="col-lg-3">
                                                    <input type="text"  class="form-control" name="data[field5][]" value="<?= $content->field5[$i] ?>">
                                                </div>
                                                <label class="col-lg-2">Field 5 Link: </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" name="data[field5link][]" value="<?= $content->field5link[$i] ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Hide: </label>
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="data[show][]">
                                                        <option value="0" <?php if(isset($content->show[$i]) && $content->show[$i] =="0" ) {echo "selected";} ?>>No</option>
                                                        <option value="1" <?php if(isset($content->show[$i]) && $content->show[$i] =="1" ) {echo "selected";} ?>>Yes</option>
                                                    </select>                                                    
                                                    
                                                </div>                                            
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2">Ribbon Text: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[ribbon_text][]" value="<?= $content->ribbon_text[$i] ?>" autocomplete="off">
                                                </div>                                                 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3">Ribbon Background Color: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control cp-basic inptSet" name="data[ribbon_bg][]" value="<?= $content->ribbon_bg[$i] ?>" autocomplete="off">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3">Ribbon Text Color: </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control cp-basic inptSet" name="data[ribbon_text_color][]" value="<?= $content->ribbon_text_color[$i] ?>" autocomplete="off">
                                                </div>                                            
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Pop-Up Text: </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="data[popup_text][]" value="<?= $content->popup_text[$i] ?>" autocomplete="off">
                                                </div>                                                 
                                            </div>
                                            
                                            <?php if($page_id ==0): ?>
                                                <div class="form-group">
                                                    <label class="col-lg-2">Exclude Page: </label>
                                                    <div class="col-lg-10"> 
                                                        <input type="hidden" class="e12" style="width:100%" name="data[exclude_page][]" value="<?php if(isset($content->exclude_page[$i])) {echo $content->exclude_page[$i];} ?>"/>
                                                        
                                                    </div>                                            
                                                </div>
                                            <?php endif ?>
                                            
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php endif; ?>
                        </div> 
                        
                        <div class="form-group">         
                            <button type="button" id="more_record" class="btn btn-default">Add more </button>
                            <hr>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-12">
                            <div class="button_container">                                
                                <input type="hidden" name="page_id" value="<?=$record->page_id?>">
                                <input type="submit" class="btn btn-primary" value="Save" name="update_request">                                
                            </div>
                            </div>
                        </div>
                    

                </div>
            </div>
       </form>
        </div>
</div>

<script type="text/javascript">    
    $(function() {
        //$(".e12").select2({width: "resolve", tags:<?=$pages_arr?>});
        
        $("#container_form").find(".e12").select2({width: "resolve", tags:<?=$pages_arr?>});
    });
</script>
<script type="text/javascript">
jQuery( function($) {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    
  } );
jQuery(document).ready(function($){   
     if($("#sortable").contents().length < 1){
         add_record('1');          
     }
     
     var colorpicker = $('.cp-basic').colorpicker({
            parts: 'full',
            showOn: 'both',
            buttonColorize: true,
            buttonImage:'<?=PRD_PLUGIN_URL?>/admin/colorpicker/images/ui-colorpicker.png',
            showNoneButton: true,
            alpha: true,
            colorFormat: 'HEX'
        });
     
     
    function add_record(index_val){
        
       /* var clone_data = $("#pre_loaded_html");
        clone_data.find(".e12").select2("destroy");
        var index_value_generate = $("#sortable").contents().length;
        var collapse_id  = parseInt(index_value_generate)+1;
        
        
        clone_data.find(".collapse").removeClass("in");        
        clone_data.find(".accordion-toggle").attr("href",  "#" + (collapse_id));
        clone_data.find(".panel-body").attr("id", collapse_id).addClass("collapse").removeClass("in");    
        
        
       
        
        $(".load_html").append(clone_data.html());
        //$("#pre_loaded_html .html_content").clone(true).appendTo(".load_html");
        $(".e12").select2({width: "resolve", tags:<?=$pages_arr?>});        
        if(index_val== "1"){
            $( ".load_html :nth-child(1)" ).find('.panel-heading').hide();
        }*/
        
        
        var index_value_generate = $("#sortable").contents().length;
        var collapse_id  = parseInt(index_value_generate)+1;
        
        var $template = $("#pre_loaded_html ").children('.html_content');
        $template.find(".e12").select2("destroy");
        var $newPanel = $template.clone();
       
        //$newPanel.find(".collapse").removeClass("in");
        $newPanel.find(".accordion-toggle").attr("href",  "#" + (collapse_id));
                
        $newPanel.find(".panel-collapse").attr("id", collapse_id).addClass("collapse").removeClass("in");
        $(".load_html").append($newPanel.fadeIn());
        $(".e12").select2({width: "resolve", tags:<?=$pages_arr?>}); 
        if(index_val== "1"){
            $( ".load_html :nth-child(1)" ).find('.panel-heading').children('.button_remove').hide();
        }
        $( "#sortable" ).sortable('refresh');        
        
        
        
        /*Color picker*/      
        $template.find(".cp-color").colorpicker({
            destroy:true
        });
        $(".cp-color").colorpicker({
         parts: 'full',
         showOn: 'both',
         buttonColorize: true,
         buttonImage:'<?=PRD_PLUGIN_URL?>/admin/colorpicker/images/ui-colorpicker.png',
         showNoneButton: true,
         alpha: true,
         colorFormat: 'HEX'
        });
       
    }    
    $("#more_record").click(function(){
        add_record('');
    });
    
    $("body").on("click",".remove_container",function(){
       var $this = $(this);       
       $this.parent().parent().parent().parent().remove();
    });
});

jQuery(function($){
var cnt =1;
  // Set all variables to be used in scope
  var frame,
     
      addImgLink = $('.upload-custom-img'),
      delImgLink = $( '.delete-custom-img'),
      imgContainer = $( '.custom-img-container'),
      imgIdInput = $( '.custom-img-id' );
  
  // ADD IMAGE LINK
  $("body").on( 'click', '.upload-custom-img', function( event ){
      
    var eventparent =$(this).parent();  
    //console.log("JHello "+cnt++);
    //eventparent.addClass( "index_"+ cnt++);
    //eventparent.children('.custom-img-container').addClass( "index_"+ cnt++);
    
      delImgLink = eventparent.find( '.delete-custom-img'),
      addImgLink = eventparent.find( '.upload-custom-img'),
      imgContainer = eventparent.find('.custom-img-container'),
      imgIdInput = eventparent.find( '.custom-img-id' );
    
    event.preventDefault();
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();
      console.log("Child "+eventparent.attr('class'));
      // Send the attachment URL to our custom image input field.
      imgContainer.html( '<img src="'+attachment.url+'" alt="" class="imgthumb"/>' );

      // Send the attachment id to our hidden input
      imgIdInput.val( attachment.id );

      // Hide the add image link
      addImgLink.addClass( 'hidden' );
      

      // Unhide the remove image link
      delImgLink.removeClass( 'hidden' );
    });

    // Finally, open the modal on click
    frame.open();
  });
  
$("body").on( 'click', '.delete-custom-img', function( event ){  
    var eventparent =$(this).parent();  
    delImgLink = eventparent.find( '.delete-custom-img'),
    addImgLink = eventparent.find( '.upload-custom-img'),
    imgContainer = eventparent.find('.custom-img-container'),
    imgIdInput = eventparent.find( '.custom-img-id' );    
    event.preventDefault();
    imgContainer.html( '' );
    addImgLink.removeClass( 'hidden' );   
    delImgLink.addClass( 'hidden' );   
    imgIdInput.val( '' );
  });

});

</script>