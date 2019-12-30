<?php if(!empty($record)): ?>
<!------- rev slider -------------->
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/rev/rev-css.css">
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/rev/settings.css">
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/rev/layers.css">
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/rev/navigation.css">
<!------- rev slider -------------->

<div class="slider-container light rev_slider_wrapper" style="height: 850px;">
    <div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': 1170, 'gridheight': 850, 'disableProgressBar': 'on', 'responsiveLevels': [4096,1200,992,500], 'navigation' : {'arrows': { 'enable': true, 'style': 'arrows-style-1 arrows-big arrows-dark' }, 'bullets': {'enable': false, 'style': 'bullets-style-1 bullets-color-primary', 'h_align': 'center', 'v_align': 'bottom', 'space': 7, 'v_offset': 70, 'h_offset': 0}}}">
        
        <ul>
            
            <?php 
                $cnt=1; 
                foreach($record as $r): 
                    $image = $this->getImageMWPL($r->ID,'Orginal'); 
            
                    $main_title = $r->post_title;
                    $text_1 = '';
                    $text_2= '';
                    if(strlen($main_title) > 40){
                        $text_1 = substr($r->post_title, 0,40);
                        $text_2 = substr($r->post_title, 41, strlen($r->post_title));
                    }else{
                        $text_1 = $main_title;
                    }
            
            ?>
            <?php if($cnt%2!=0){?>
                <li data-transition="fade">
                    <img src="<?=$image?>" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">
                    <h1 class="tp-caption font-weight-extra-bold text-color-dark negative-ls-2" data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]' data-x="['left','left','center','center']" data-hoffset="['152','152','0','0']" data-y="center" data-fontsize="['50','50','50','90']" data-lineheight="['55','55','55','95']" data-letterspacing="-1">
                        <?= $text_1 ?>
                        <?php if($text_2 !=""): ?>
                        <br>
                        <?= $text_2?>
                        <?php endif; ?>
                    </h1>
                </li>
            <?php } else { ?>
                <li data-transition="fade">
                    <img src="<?=$image?>" alt="" data-bgposition="right center" data-bgpositionend="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-kenburns="on" data-duration="9000" data-ease="Linear.easeNone" data-scalestart="110" data-scaleend="100" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="0" class="rev-slidebg">
                    <div class="tp-caption color-ooo font-weight-extra-bold text-color-dark negative-ls-2" data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]' data-x="center" data-y="center" data-voffset="['-50','-50','-50','-75']" data-fontsize="['50','50','50','90']" data-lineheight="['55','55','55','95']">
                        <?= $text_1 ?>
                        <?php if($text_2 !=""): ?>
                        <br>
                        <?= $text_2?>
                        <?php endif; ?>
                    </div>
                </li>     
            <?php } ?>
            <?php $cnt++; endforeach; ?>
        </ul>
    </div>
</div>


<?php endif; ?>