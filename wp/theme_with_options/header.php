<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php wp_title('', true,''); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" href="<?php bloginfo('template_url') ?>/img/fav-icon.png">
    <link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/assets/img/favicon.ico">
    <?php wp_head(); ?>
    <!------- bootstrap -------------->
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/assets/css/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/assets/css/style_mwpl.css">
    <link rel='stylesheet' type='text/css' href='<?php bloginfo('template_url') ?>/assets/css/style_mwpl.php' />

</head>

<body class="mwpl-bg-body">

    <!------ Main Header ------->
    <div class="container-fluid mwpl-header">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 mwpl-left">
                    <div class="inner">
                        <figure class="mwpl-logo">
                            <a href="<?= home_url()?>">
                                <img src="<?= getThemeInfo('logo')?>" alt="Logo">
                            </a>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(is_front_page()): ?>
    <div class="container-fluid mwpl-secondary-header mb-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner">
                        <h1 class="mwpl-hdng" style="/*font-size:31px;font-family: 'Rubik-Medium', sans-serif;*/"><?= getThemeInfo('headTitle')?></h1>
                        <div class="mwpl-subHeading">
                            <?= getThemeInfo('headSubTitle')?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
