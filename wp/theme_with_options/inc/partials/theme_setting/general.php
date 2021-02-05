<link rel="stylesheet" href="<?=MWPL_PARTIALS_URL.'/assets/css/select2/select2.min.css'?>"  />
<link rel="stylesheet" href="<?=MWPL_PARTIALS_URL.'/assets/css/font-awesome/font-awesome.css'?>">
<link rel="stylesheet" href="<?=MWPL_PARTIALS_URL.'/assets/css/theme_settings_style.css'?>" />

<div style="width: 70%;margin: 30px auto;display: flex;max-width: 100%;flex-wrap: wrap;">

    <section class="mwpl-fluid">
        <form method="post" action="<?php admin_url( 'themes.php?page=theme-settings' ); ?>" id="themesettingform">
            <?php wp_nonce_field( "mwpl-settings-page" );  ?>
            <div class="inner hdr">
                <div class="left">
                    <h5>
                        <i class="fas fa-cog"></i>
                        Theme Option
                    </h5>
                </div>

                <div class="right">
                    <div class="heading">
                        <h3>Theme Option</h3>
                    </div>

                    <div class="buttons">
                        <ul>
                            <li>
                                <button type="button" class="save saveInformation">
                                    <i class="fas fa-check"></i>
                                    <span>
                                        Save
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="inner">
                <div id="mwpl_custom_tabs" class="mwpl-tab-box">

                    <div class="left">
                        <ul>
                            <li>
                                <a href="#mwpl_custom_tabs-01">
                                    <i class="fas fa-home"></i>
                                    <span>General</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mwpl_custom_tabs-02">
                                    <i class="far fa-copy"></i>
                                    <span>Top Bar - Head</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mwpl_custom_tabs-03">
                                    <i class="far fa-copy"></i>
                                    <span>Header</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mwpl_custom_tabs-04">
                                    <i class="far fa-images"></i>
                                    <span>Footer</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="right">
                        <div id="mwpl_custom_tabs-01" class="">

                            <div class="mwpl-card-header">
                                <h3>General</h3>
                            </div>
                            <div class="inner-box">
                                
                                <div class="inner">
                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Email
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-50 ap-mW-100">
                                                <?php 
                                                    $email = get_option('admin_email'); 
                                                    if(isset($data["mwpl_email"]) && $data["mwpl_email"] !=""){
                                                        $email = esc_html( stripslashes($data["mwpl_email"]));
                                                    }
                                                ?>
                                                <input type="text" autocomplete='off' class="ap-input" name="mwpl_email" value="<?= $email; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Phone Number
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-50 ap-mW-100">
                                                <input type="text" class="ap-input" autocomplete='off' name="mwpl_phone" value="<?php echo esc_html( stripslashes( $data["mwpl_phone"] ) ); ?>">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Address
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <textarea class="ap-textarea" autocomplete='off'  name="mwpl_address" placeholder="Enter your address...."><?php echo esc_html( stripslashes( $data["mwpl_address"] ) ); ?></textarea>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Background Color
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <?php $backColor ="#000000"; 
                                            if(isset($data["mwpl_background_color"]) && $data["mwpl_background_color"] !=""){
                                                $backColor = esc_html( stripslashes( $data["mwpl_background_color"] ) );
                                            }
                                            ?>
                                            <div class="ap-input-box ap-w-100 mwpl-relative-position">
                                                <input type="color" class="ap-input-color" name="mwpl_background_color" value="<?=$backColor;?>">  
                                                <span class="ap-colorDisplay"><?=$backColor;?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Background Image
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <input type="button" class="upload-custom-logo ap-btn ap-btn-success" value="Choose Picture">
                                                <input type="button" class="delete-custom-logo ap-btn ap-btn-danger <?= ($data["mwpl_background"]=="" ? "hidden":"")?> " value="Remove Picture">
                                                <div class="custom-logo-container">
                                                    <?php if($data["mwpl_background"]!=""): ?>
                                                    <?php $img =  wp_get_attachment_image_src( $data["mwpl_background"], 'thumbnail' ) ?>
                                                        <img src="<?=$img[0]?>" class="imgthumb">
                                                    <?php endif; ?>
                                                </div>
                                                <input type="hidden" name="mwpl_background" class="custom-logo-id" value="<?php echo esc_html( stripslashes( $data["mwpl_background"] ) ); ?>"> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <div id="mwpl_custom_tabs-02">
                            
                            <div class="mwpl-card-header">
                                <h3>Top bar - Head Section</h3>
                            </div>
                            
                            <div class="inner-box">
                                <div class="inner">


                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Logo
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">

                                                <input type="button" class="upload-custom-logo ap-btn ap-btn-success" value="Choose Logo">
                                                <input type="button" class="delete-custom-logo ap-btn ap-btn-danger <?= ($data["mwpl_logo"]=="" ? "hidden":"")?>" value="Remove Logo">
                                                <div class="custom-logo-container">
                                                    <?php if($data["mwpl_logo"]!=""): ?>
                                                    <?php $img =  wp_get_attachment_image_src( $data["mwpl_logo"], 'thumbnail' ) ?>
                                                        <img src="<?=$img[0]?>" class="imgthumb">
                                                    <?php endif; ?>
                                                </div>
                                                <input type="hidden" name="mwpl_logo" class="custom-logo-id" value="<?php echo esc_html( stripslashes( $data["mwpl_logo"] ) ); ?>"> 

                                            </div>
                                        </div>
                                    </div>


                                    
                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Top bar Height/Color
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-50 ap-mW-100">
                                                <input type="number" class="ap-input" placeholder="Height. Example: 20" name="mwpl_topbar_height" value="<?php echo esc_html( stripslashes( $data["mwpl_topbar_height"] ) ); ?>">
                                            </div>

                                            <?php $topBarColor ="#108934"; 
                                            if(isset($data["mwpl_topbar_color"]) && $data["mwpl_topbar_color"] !=""){
                                                $topBarColor = esc_html( stripslashes( $data["mwpl_topbar_color"] ) );
                                            }?>
                                            <div class="ap-input-box ap-w-50 mwpl-relative-position">
                                                <input type="color" class="ap-input-color" name="mwpl_topbar_color" value="<?=$topBarColor;?>">  
                                                <span class="ap-colorDisplay"><?=$topBarColor;?></span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="mwpl_custom_tabs-03">
                            <div class="mwpl-card-header">
                                <h3>Header Section</h3>
                            </div>
                            <div class="inner-box">
                                <div class="inner">

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Icon
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <input type="button" class="upload-custom-logo ap-btn ap-btn-success" value="Choose Icon">
                                                <input type="button" class="delete-custom-logo ap-btn ap-btn-danger <?= ($data["mwpl_head_icon"]=="" ? "hidden":"")?> " value="Remove Icon">
                                                <div class="custom-logo-container">
                                                    <?php if($data["mwpl_head_icon"]!=""): ?>
                                                    <?php $img =  wp_get_attachment_image_src( $data["mwpl_head_icon"], 'thumbnail' ) ?>
                                                        <img src="<?=$img[0]?>" class="imgthumb">
                                                    <?php endif; ?>
                                                </div>
                                                <input type="hidden" name="mwpl_head_icon" class="custom-logo-id" value="<?php echo esc_html( stripslashes( $data["mwpl_head_icon"] ) ); ?>"> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Title
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <input type="text" class="ap-input" autocomplete='off' name="mwpl_head_title" value="<?php echo esc_html( stripslashes( $data["mwpl_head_title"] ) ); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Title - Font Style
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-50 ap-mW-100">
                                                <select  class="js-states form-control single" name="mwpl_head_title_font_style">
                                                    <?php $existHead = ''; $existHead = esc_html( stripslashes( $data["mwpl_head_title_font_style"] )); ?>
                                                    <option value="">Choose Font Style</option>
                                                    <?php
                                                    if(!empty($fontsLib->items)):
                                                        foreach($fontsLib->items as $font):?>
                                                            <option value="<?=$font->family .','.$font->category?>" <?=($existHead == $font->family .','.$font->category ? "selected":"" )?>><?=$font->family .'('.$font->category.')'?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Title - Font Size
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-25 ap-mW-100">
                                                <span>Web</span>
                                                <input type="number" class="ap-input" placeholder="Font Size - Web" autocomplete='off' name="mwpl_head_title_font_size_web" value="<?php echo esc_html( stripslashes( $data["mwpl_head_title_font_size_web"] ) ); ?>">
                                            </div>
                                        
                                            <div class="ap-input-box ap-w-25 ap-mW-100">
                                                <span>Tablet</span>
                                                <input type="number" class="ap-input" placeholder="Font Size - Tablet" autocomplete='off' name="mwpl_head_title_font_size_tablet" value="<?php echo esc_html( stripslashes( $data["mwpl_head_title_font_size_tablet"] ) ); ?>">
                                            </div>
                                        
                                            <div class="ap-input-box ap-w-25 ap-mW-100">
                                                <span>Mobile</span>
                                                <input type="number" class="ap-input" placeholder="Font Size - Mobile" autocomplete='off' name="mwpl_head_title_font_size_mobile" value="<?php echo esc_html( stripslashes( $data["mwpl_head_title_font_size_mobile"] ) ); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Sub Title
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <textarea class="ap-textarea" placeholder="Enter content...." name="mwpl_head_titlesub"><?php echo esc_html( stripslashes( $data["mwpl_head_titlesub"] ) ); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Sub-Title - Font Style
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-50 ap-mW-100">
                                                
                                                <?php $existSubHead = ''; $existSubHead = esc_html( stripslashes( $data["mwpl_head_titlesub_font_style"] )); ?>
                                                <select  class="js-states form-control single" name="mwpl_head_titlesub_font_style">
                                                    <option value="">Choose Font Style</option>
                                                    <?php
                                                    if(!empty($fontsLib->items)):
                                                        foreach($fontsLib->items as $font):?>
                                                            <option value="<?=$font->family .','.$font->category?>" <?=($existSubHead == $font->family .','.$font->category ? "selected":"" )?> ><?=$font->family .'('.$font->category.')'?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Sub-Title - Font Size
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-25 ap-mW-100">
                                                <span>Web</span>
                                                <input type="number" class="ap-input" placeholder="Font Size - Web" autocomplete='off' name="mwpl_head_titlesub_font_size_web" value="<?php echo esc_html( stripslashes( $data["mwpl_head_titlesub_font_size_web"] ) ); ?>">
                                            </div>
                                        
                                            <div class="ap-input-box ap-w-25 ap-mW-100">
                                                <span>Tablet</span>
                                                <input type="number" class="ap-input" placeholder="Font Size - Tablet" autocomplete='off' name="mwpl_head_titlesub_font_size_tablet" value="<?php echo esc_html( stripslashes( $data["mwpl_head_titlesub_font_size_tablet"] ) ); ?>">
                                            </div>
                                        
                                            <div class="ap-input-box ap-w-25 ap-mW-100">
                                                <span>Mobile</span>
                                                <input type="number" class="ap-input" placeholder="Font Size - Mobile" autocomplete='off' name="mwpl_head_titlesub_font_size_mobile" value="<?php echo esc_html( stripslashes( $data["mwpl_head_titlesub_font_size_mobile"] ) ); ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="mwpl_custom_tabs-04">
                            <div class="mwpl-card-header">
                                <h3>Footer Section</h3>
                            </div>
                            <div class="inner-box">
                                <div class="inner">
                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Copyright Text
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <textarea class="ap-textarea" placeholder="Enter content...." name="mwpl_footer_copyright"><?php echo esc_html( stripslashes( $data["mwpl_footer_copyright"] ) ); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mwpl-form-row">
                                        <div class="mwpl-form-group ap-col-left mwpl-align-center">
                                            <label class="ap-label">
                                                Google/Other Script
                                            </label>
                                        </div>

                                        <div class="mwpl-form-group ap-col-right">
                                            <div class="ap-input-box ap-w-100">
                                                <textarea class="ap-textarea" placeholder="Enter content...." name="mwpl_footer_scriptCode"><?php echo esc_html( stripslashes( $data["mwpl_footer_scriptCode"] ) ); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mwpl-form-row">
                                        <h1>Footer Icons</h1>
                                        
                                        <div class="mwpl_addmore_footer_icons">
                                            <button type="button" class="ap-btn ap-btn-success smallbtn addmorefootericon">Add more</button>
                                        </div>
                                        
                                        <div class="main_container_footer_icon" style="width: 100%">
                                            <?php if(isset($data['mwpl_footer_icons']) && !empty($data['mwpl_footer_icons'])): ?>
                                            <?php $footericonsExist = json_decode($data['mwpl_footer_icons']);?>
                                            <?php if(!empty($footericonsExist)): ?>
                                            <?php for($i=0;$i<count($footericonsExist->icon);$i++): ?>
                                            
                                            
                                            <div class="mwpl-form-group mwpl_container_group">
                                                <div class="ap-input-box ap-w-25 ap-mW-100">
                                                    <input type="button" class="upload-custom-logo ap-btn small ap-btn-success smallbtn <?= ($footericonsExist->icon[$i]!="" ? "hidden":"")?>" value="Choose Icon">
                                                    <input type="button" class="delete-custom-logo ap-btn small ap-btn-danger smallbtn <?= ($footericonsExist->icon[$i]=="" ? "hidden":"")?>" value="Remove Icon">
                                                    <div class="custom-logo-container">
                                                        <?php if($footericonsExist->icon[$i]!=""): ?>
                                                        <?php $img =  wp_get_attachment_image_src( $footericonsExist->icon[$i], 'thumbnail' ) ?>
                                                            <img src="<?=$img[0]?>" class="imgthumb">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="hidden" name="mwpl_footer_icons[icon][]" class="custom-logo-id" value="<?php echo esc_html( stripslashes( $footericonsExist->icon[$i] ) ); ?>"> 
                                                </div>

                                                <div class="ap-input-box ap-w-50 ap-mW-100">
                                                    <input type="text" class="ap-input" placeholder="Icon Link" autocomplete="off" name="mwpl_footer_icons[link][]" value="<?php echo esc_html( stripslashes( $footericonsExist->link[$i] ) ); ?>">
                                                </div>
                                                <div class="ap-input-box ap-w-25 ap-mW-100">
                                                    <a href="javascript:void(0)" class="removeicon ap-btn-danger smallbtn ap-btn">Remove</a>
                                                </div>
                                            </div>
                                            
                                            <?php endfor; ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                    </div>


                                </div>
                            </div>


                        </div>
                        
                        <div class="inner">
                            <div class="mwpl-saving-btn">
                                <p class="text-center">
                                    <button type="button" class="ap-btn ap-btn-success saveInformation">
                                        Save
                                    </button>
                                </p>
                            </div>
                        </div>


                    </div>

                </div>

            </div>
            
            <input type="hidden" name="action" value="get">
            <input type="hidden" name="mwpl-settings-submit" value="Y" />
        </form>
    </section>
    
    
    
</div>

<div class="layout-loading">
    <div class="loader">
        <span id="msg">Loading...</span>
    </div>
</div>

<div id="iconfootergroup" class="hidden">
    <div class="mwpl-form-group mwpl_container_group">
        <div class="ap-input-box ap-w-25 ap-mW-100">
            <input type="button" class="upload-custom-logo ap-btn small ap-btn-success smallbtn" value="Choose Icon">
            <input type="button" class="delete-custom-logo ap-btn small ap-btn-danger hidden smallbtn" value="Remove Icon">
            <div class="custom-logo-container"></div>
            <input type="hidden" name="mwpl_footer_icons[icon][]" class="custom-logo-id"> 
        </div>

        <div class="ap-input-box ap-w-50 ap-mW-100">
            <input type="text" class="ap-input" placeholder="Icon Link" autocomplete="off" name="mwpl_footer_icons[link][]">
        </div>
        <div class="ap-input-box ap-w-25 ap-mW-100">
            <a href="javascript:void(0)" class="removeicon ap-btn-danger smallbtn ap-btn">Remove</a>
        </div>
    </div>
</div>


<script src="<?=MWPL_PARTIALS_URL?>/assets/js/jquery-ui.js"></script>
<script src="<?=MWPL_PARTIALS_URL?>/assets/js/select2.min.js"></script>

<script type="text/javascript">

jQuery(document).ready(function($){
    
    $(function(){
        var checkExist = $('.main_container_footer_icon').html().trim().length;
        if(!checkExist){
            $(this).addIconsSlide();
        }
    })
    $('.addmorefootericon').click(function(){
        $(this).addIconsSlide();
    });
    
    $.fn.addIconsSlide=function(){
        var htmlcontent  = $("#iconfootergroup").children().clone();
        $(".main_container_footer_icon").append(htmlcontent);
    }
    
    $('body').on('click','.removeicon',function(){
        var x = confirm('Are you sure, you want to delete ?');
        if(x ==true){
            $(this).parent().parent().remove();
        }
    });
    
    
    $(".single").select2({
        placeholder: "Choose Font Family",
        allowClear: true
    });
    
    $(".single").select2().select2("", null);

    $(function() {
        $("#mwpl_custom_tabs").tabs();
        
    });
    
    
    var $d1 = $(".ap-input-color");
    $d1.on("change", function() {
        var $inp = $(this);
        var from = $inp.prop("value");
        $inp.next('.ap-colorDisplay').html(from);
    });
    
    
    
   $(".saveInformation").click(function(){
       $(this).loaders('show','#4cb2e1',"Saving.....");
       $(this).saveAjaxData(); 
   });
   
   $.fn.loaders=function(display,color,message){
       if(display == "show"){
            $('.loader').css({'background':color});
            $("#msg").text(message);
            $('.layout-loading').show();
            setTimeout(function(){ $(this).loaders('hide','','') }, 1500);
       }else{
           $('.layout-loading').hide();
       }
   }
   
   $.fn.saveAjaxData = function(){
       var  dataform = $("#themesettingform").serialize();
        $.ajax({
            type : "POST",
            dataType:'json',
            url : "<?= admin_url('admin-ajax.php') ?>",
            data : dataform,
            success: function(response) {
                if(response.status == "success"){
                    $(this).loaders('show','#00D505',response.message);
                }else{
                    $(this).loaders('show','#FF4040',response.message);
                }
            },
            error:function(){
                $(this).loaders('show','#FF4040',"Something went wrong, Please try after some time.");
                
            }
       });
   }
    
    
    
    jQuery(function($){

    // Set all variables to be used in scope
    var frame,

        addVideoLink = $('.upload-custom-logo'),
        delVideoLink = $( '.delete-custom-logo'),
        videoContainer = $( '.custom-logo-container'),
        videoIdInput = $( '.custom-logo-id' );

    // ADD Video
      $("body").on( 'click', '.upload-custom-logo', function( event ){

      var eventparent =$(this).parent();  

      $("#wp_product_metabox_details_video_gallery").removeClass('closed');


        delVideoLink = eventparent.find( '.delete-custom-logo'),
        addVideoLink = eventparent.find( '.upload-custom-logo'),
        videoContainer = eventparent.find('.custom-logo-container'),
        videoIdInput = eventparent.find( '.custom-logo-id' );

      event.preventDefault();

      // If the media frame already exists, reopen it.
      if ( frame ) {
        frame.open();
        return;
      }

      // Create a new media frame
      frame = wp.media({
        title: 'Select or Upload Theme Images',
        button: {
          text: 'Insert'
        },
        multiple: false,
        library : {
            type : 'image',
        },
      });


      // When an image is selected in the media frame...
      frame.on( 'select', function() {
        // Get media attachment details from the frame state
        var attachment = frame.state().get('selection').first().toJSON();
        // Send the attachment URL to our custom image input field.
        if(attachment.type == "image"){
            videoContainer.html( '<img src="'+attachment.url+'" alt="" class="imgthumb"/>');
        }else{
            alert("Choose only image");
            return false;
        }
        // Send the attachment id to our hidden input
        videoIdInput.val( attachment.id );

        // Hide the add image link
        addVideoLink.addClass( 'hidden' );


        // Unhide the remove image link
        delVideoLink.removeClass( 'hidden' );
      });

      // Finally, open the modal on click
      frame.open();
    });
      $("body").on( 'click', '.delete-custom-logo', function( event ){  
      var eventparent =$(this).parent();  
      delVideoLink = eventparent.find( '.delete-custom-logo'),
      addVideoLink = eventparent.find( '.upload-custom-logo'),
      videoContainer = eventparent.find('.custom-logo-container'),
      videoIdInput = eventparent.find( '.custom-logo-id' );    
      event.preventDefault();
      videoContainer.html( '' );
      addVideoLink.removeClass( 'hidden' );   
      delVideoLink.addClass( 'hidden' );   
      videoIdInput.val( '' );

     
    });
  });
});
      
</script>