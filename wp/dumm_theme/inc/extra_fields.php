<?php

Class Extra_fields extends Wp_Common{
    
    function __construct(){
        add_action( 'save_post', array($this,'metabox_save') );
    }
    function load_meta_fields(){
        add_action( 'add_meta_boxes', array($this,'metabox_add'));   
    }
    public function metabox_add(){
        add_meta_box( 'wp_product_metabox_details', 'Page Details', array($this,'wp_product_metabox_details'), 'page', 'normal', 'high' );
    }
    function wp_product_metabox_details($post){
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
        $exist_value = json_decode($this->getMetavalue($post->ID, 'about_information'));    
       
        ?>
        <style>
            .mb10{
                margin-bottom: 10px !important;
                float: left;
                width: 100%;
            }
            .custom-img-container{
                margin: 10px 0px;
            }
            .imgthumb{
                width: 200px;
            }
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>
        <div class="wrap">
        <div class="container" >
        <div class="row">
                
                
                <div class="form-container" id="container_form">
                    
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
                                        
                                            <div class="form-group mb10">                                            
                                                <label class="col-lg-2">Title: </label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="info[title][]">
                                                </div>
                                            </div>

                                           
                                            <div class="form-group mb10">
                                                <label class="col-lg-2">Description: </label>
                                                <div class="col-lg-10">                                                
                                                    <textarea class="form-control" name="info[description][]" rows="10"></textarea>
                                                </div>                                            
                                            </div>
                                           
                                            <div class="form-group mb10">
                                                <label class="col-lg-2">Picture: </label>
                                                <div class="col-lg-10">
                                                    <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                    <input type="button" class="btn btn-danger delete-custom-img hidden" value="Delete">
                                                    <div class="mb10 custom-img-container"></div>
                                                    <input type="hidden" name="info[picture][]" class="custom-img-id">                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2">Bottom Side: </label>
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="info[bottom][]">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select> 
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="load_html" id='sortable'>
                        <?php 
                        $record = $this->getMetavalue($post->ID, 'about_information');  
                        if($record!=""): ?>
                            <?php $content = json_decode($record); ?>                           
                            
                            <?php for($i=1;$i<count($content->description);$i++){?>
                            <div class="form-group html_content">           
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="button_remove col-lg-2">
                                                <a href="javascript:void(0)" class="remove_container" >Remove</a>
                                            </div>                                            
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#sortable" href="#accord_<?=$i?>"> Expand #<?= $content->title[$i] ?> </a>

                                        </div>
                                        <div class="panel-collapse collapse" id="accord_<?=$i?>">
                                            <div class="panel-body" >
                                                <div class="form-group mb10">                                            
                                                    <label class="col-lg-2">Title: </label>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="info[title][]" value="<?= $content->title[$i] ?>">
                                                    </div>
                                                </div>


                                                <div class="form-group mb10">
                                                    <label class="col-lg-2">Description: </label>
                                                    <div class="col-lg-10">                                                
                                                        <textarea class="form-control" name="info[description][]" rows="10"><?= $content->description[$i] ?></textarea>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group mb10">
                                                    <label class="col-lg-2">Picture: </label>
                                                    <div class="col-lg-10">    
                                                        <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                                                        <input type="button" class="btn btn-danger delete-custom-img <?php if($content->picture[$i] ==""){echo "hidden";} ?>" value="Delete">
                                                        <div class="m-t-10 custom-img-container">
                                                            <?php if($content->picture[$i]!=""): ?>
                                                            <?php $img =  wp_get_attachment_image_src( $content->picture[$i], 'thumbnail' ) ?>
                                                                <img src="<?=$img[0]?>" class="imgthumb">
                                                            <?php endif; ?>
                                                                                                          
                                                        </div>
                                                        <input type="hidden" name="info[picture][]" class="custom-img-id" value="<?= $content->picture[$i] ?>">       
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2">Bottom Side: </label>
                                                    <div class="col-lg-3">
                                                        <select class="form-control" name="info[bottom][]">
                                                            <option value="0" <?php if(isset($content->bottom[$i]) && $content->bottom[$i] =="0" ) {echo "selected";} ?>>No</option>
                                                            <option value="1" <?php if(isset($content->bottom[$i]) && $content->bottom[$i] =="1" ) {echo "selected";} ?>>Yes</option>
                                                        </select> 
                                                    </div>                                            
                                                </div>
                                                
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

                </div>
            </div>
        </div>
       </div>
       
        <script type="text/javascript">
        jQuery.noConflict();
        jQuery( function($) {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        });
        jQuery(document).ready(function($){             
             if($("#sortable").contents().length < 2){
                 add_record('1');          
             }
            function add_record(index_val){               
                var index_value_generate = $("#sortable").contents().length;
                
                var collapse_id  = parseInt(index_value_generate)+1;
                
                var $template = $("#pre_loaded_html ").children('.html_content');                
                var $newPanel = $template.clone();
                

                //$newPanel.find(".collapse").removeClass("in");
                $newPanel.find(".accordion-toggle").attr("href",  "#" + (collapse_id));

                $newPanel.find(".panel-collapse").attr("id", collapse_id).addClass("collapse").removeClass("in");
                $(".load_html").append($newPanel.fadeIn());              
                if(index_val== "1"){
                    $( ".load_html :nth-child(1)" ).find('.panel-heading').children('.button_remove').hide();
                }
                $( "#sortable" ).sortable('refresh');

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
             // console.log("Child "+eventparent.attr('class'));
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
                            
        <?php
    }
    function metabox_save($post_id){
        global  $wpdb;
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
         // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;

        // now we can actually save the data
        $allowed = array( 
                'a' => array( // on allow a tags
                        'href' => array() // and those anchords can only have href attribute
                )
        );
      
        if(isset($_POST['info'])){
           $data = json_encode(  esc_sql($_POST['info']));           
           update_post_meta( $post_id, 'about_information', $data );          
        }
        //echo "<pre>"; print_r($_POST); echo "</pre>"; die();
        if(isset($_POST['info_eat'])){
           $data = json_encode(  esc_sql($_POST['info_eat']));           
           update_post_meta( $post_id, 'eat_information', $data );          
        }
    }
    
    
    /*Eat*/
    function load_meta_fields_eat(){
        add_action( 'add_meta_boxes', array($this,'metabox_add_eat'));   
    }
    public function metabox_add_eat(){
        add_meta_box( 'wp_product_metabox_details_eat', 'Menu Details', array($this,'wp_product_metabox_details_eat'), 'eat', 'normal', 'high' );
    }
    function wp_product_metabox_details_eat($post){
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
        $exist_value = json_decode($this->getMetavalue($post->ID, 'about_information'));    
       
        ?>
        <style>
            .mb10{
                margin-bottom: 10px !important;
                float: left;
                width: 100%;
            }
            .custom-img-container{
                margin: 10px 0px;
            }
            .imgthumb{
                width: 200px;
            }
        </style>


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>
       <div class="wrap">
        <div class="row" >
        <div class="col-xs-12">
                
                
                <div class="form-container" id="container_form">
                    
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
                                            
                                            <div class="form-group mb10">                                            
                                                <label class="col-lg-5"><h1>Dish Information:</h1> </label>                                                
                                            </div>   
                                            <div class="form-group mb10">                                            
                                                <label class="col-lg-2">Dish Category: </label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="info_eat[category][]">
                                                </div>
                                            </div>
                                            <div class="form-group mb10">                                            
                                                <label class="col-lg-2">Dish Name: </label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="info_eat[title][]">
                                                </div>
                                            </div>
                                            <div class="form-group mb10">
                                                <label class="col-lg-2">Dish Description: </label>
                                                <div class="col-lg-10">
                                                   <textarea class="form-control" name="info_eat[description][]" rows="10"></textarea>
                                                </div>                                            
                                            </div>
                                            <div class="form-group mb10">                                            
                                                <label class="col-lg-2">Dish Price: </label>
                                                <div class="col-lg-5">
                                                    <input type="number" min="1" placeholder="Price From" step="0.01" class="form-control" name="info_eat[price_1][]" >

                                                </div>
                                                <div class="col-lg-5">
                                                    <input type="number" placeholder="Price To " min="1" step="0.01" class="form-control" name="info_eat[price_2][]">
                                                </div>
                                            </div>
                                                                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="load_html" id='sortable'>
                        <?php 
                        $record = $this->getMetavalue($post->ID, 'eat_information');  
                        if($record!=""): ?>
                            <?php $content = json_decode($record); ?>                           
                            
                            <?php for($i=1;$i<count($content->description);$i++){?>
                            <div class="form-group html_content">           
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="button_remove col-lg-2">
                                                <a href="javascript:void(0)" class="remove_container" >Remove</a>
                                            </div>                                            
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#sortable" href="#accord_<?=$i?>"> Expand #<?= $content->title[$i] ?> </a>

                                        </div>
                                        <div class="panel-collapse collapse" id="accord_<?=$i?>">
                                            <div class="panel-body" >
                                                <div class="form-group mb10">                                            
                                                    <label class="col-lg-2">Dish Category: </label>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="info_eat[category][]" value="<?= $content->category[$i] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group mb10">                                            
                                                    <label class="col-lg-2">Dish Name: </label>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="info_eat[title][]" value="<?= $content->title[$i] ?>">
                                                    </div>
                                                </div>


                                                <div class="form-group mb10">
                                                    <label class="col-lg-2">Dish Description: </label>
                                                    <div class="col-lg-10">                                                
                                                        <textarea class="form-control" name="info_eat[description][]" rows="10"><?= $content->description[$i] ?></textarea>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group mb10">                                            
                                                    <label class="col-lg-2">Dish Price: </label>
                                                    <div class="col-lg-5">
                                                        <input type="number" min="1" placeholder="Price From" step="0.01" class="form-control" name="info_eat[price_1][]" value="<?= $content->price_1[$i] ?>">
                                                        
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <input type="number" placeholder="Price To " min="1" step="0.01" class="form-control" name="info_eat[price_2][]" value="<?= $content->price_2[$i] ?>">
                                                    </div>
                                                </div>
                                                                                           
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

                </div>
            </div>
        </div>
       </div>
       
        <script type="text/javascript">
        jQuery.noConflict();
        jQuery( function($) {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        });
        jQuery(document).ready(function($){              
             if($("#sortable").contents().length < 2){
                 add_record('1');          
             }
            function add_record(index_val){               
                var index_value_generate = $("#sortable").contents().length;
                
                var collapse_id  = parseInt(index_value_generate)+1;
                
                var $template = $("#pre_loaded_html ").children('.html_content');                
                var $newPanel = $template.clone();
                

                //$newPanel.find(".collapse").removeClass("in");
                $newPanel.find(".accordion-toggle").attr("href",  "#" + (collapse_id));

                $newPanel.find(".panel-collapse").attr("id", collapse_id).addClass("collapse").removeClass("in");
                $(".load_html").append($newPanel.fadeIn());              
                if(index_val== "1"){
                    $( ".load_html :nth-child(1)" ).find('.panel-heading').children('.button_remove').hide();
                }
                $( "#sortable" ).sortable('refresh');

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
             // console.log("Child "+eventparent.attr('class'));
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
                            
        <?php
    }
}

