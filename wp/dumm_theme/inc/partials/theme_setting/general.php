
<?php 
$settings = $data;
wp_enqueue_media(); ?>
<style >
    .custom-img-container{
        margin:10px 0px;
    }
    .imgthumb{
        width: 300px;
        border: 1px solid #ccc;
        padding: 10px;
    }
</style>
<table class="form-table">
    <tr>
            <th><label for="mwpl_intro">Address</label></th>
            <td>
                    <textarea id="mwpl_intro" name="mwpl_address" cols="60" rows="5" ><?php echo esc_html( stripslashes( $settings["mwpl_address"] ) ); ?></textarea><br/>
                    
            </td>
    </tr>
    <tr>
        <th><label for="mwpl_phone">Phone Number</label></th>
            <td>
                <input type='text' name="mwpl_phone" value="<?php echo esc_html( stripslashes( $settings["mwpl_phone"] ) ); ?>">

            </td>
    </tr>
    <tr>
        <th><label for="mwpl_phone_whatsapp">Whats'App Number</label></th>
            <td>
                <input type='text' name="mwpl_phone_whatsapp" value="<?php echo esc_html( stripslashes( $settings["mwpl_phone_whatsapp"] ) ); ?>">

            </td>
    </tr>
    <tr>
        <th><label for="mwpl_phone_whatsapp">Picture</label></th>
        
            <td>
                <?php $picture = $settings["mwpl_picture"]; ?>
                
                <input type="button" class="btn btn-default upload-custom-img" value="Upload"> &nbsp; 
                <input type="button" class="btn btn-danger delete-custom-img <?php if($picture ==""){echo "hidden";} ?>" value="Delete">
                <div class="m-t-10 custom-img-container">
                    <?php if($picture!=""): ?>
                    <?php $img =  wp_get_attachment_image_src( $picture, 'thumbnail' ) ?>
                        <img src="<?=$img[0]?>" class="imgthumb">
                    <?php endif; ?>
                </div> 
                <input type="hidden" name="mwpl_picture" value="<?= $picture ?>" class="custom-img-id">                                                 

            </td>
    </tr>
</table>
<script type="text/javascript">
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
                          