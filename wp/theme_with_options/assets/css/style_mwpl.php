<?php
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);
header('Content-type: text/css');
header('Cache-control: must-revalidate');
?>
.mwpl-bg-body{
    background-image:url(<?=getThemeInfo('backgroundImage')?>);
    background-color:<?=getThemeInfo('backgroundColor')?>
}
.mwpl-header{
    background:<?= getThemeInfo('topBarColor')?>;
    height:<?= getThemeInfo('topBarHeight')?>;
}
.mwpl-secondary-header .mwpl-hdng{
    font-size:<?=getThemeInfo('headTitleFontSizeWeb')?>;
    font-family:<?=getThemeInfo('headTitleFontStyle')?>;
}
.mwpl-secondary-header .mwpl-hdng{
    background-image: url(<?=getThemeInfo('headIcon')?>);
}
.mwpl-subHeading ul li{
    font-size:<?=getThemeInfo('headSubTitleFontSizeWeb')?>;
    font-family:<?=getThemeInfo('headSubTitleFontStyle')?>;
}

/**** media queries *****/
/**** media queries *****/
/**** media queries *****/

@media screen and (max-width: 992px){
    .mwpl-secondary-header .mwpl-hdng {
        font-size: <?=getThemeInfo('headTitleFontSizeTablet')?>;
    }
    .mwpl-subHeading ul li {
        font-size: <?=getThemeInfo('headSubTitleFontSizeTablet')?>;
    }
}

@media screen and (max-width: 768px)
    .mwpl-secondary-header .mwpl-hdng {
        font-size: <?=getThemeInfo('headTitleFontSizeMobile')?>;
    }
    
    .mwpl-subHeading ul li {
        font-size: <?=getThemeInfo('headSubTitleFontSizeMobile')?>;
    }
}
