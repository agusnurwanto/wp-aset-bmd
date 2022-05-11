<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/loadingoverlay.min.js"></script>
<script type="text/javascript">
<?php
    $src = 'src="'.get_option('_crb_menu_video_loading').'"';
?>
    var $ = jQuery;
    function siteUrl(){ 
        return "<?php echo plugin_dir_url(dirname(__FILE__)); ?>"; 
    }
    function progressLoading() {
        $.LoadingOverlay('show', { 
            image : '', 
            custom : '<video style="position: absolute; width: 90%; top: 0; margin: auto;" autoplay muted><source <?php echo $src; ?> type="video/mp4">Your browser does not support the video tag.</video>', 
            imageAnimation : false,
            background : "rgba(0, 0, 0, 1)" 
        });
    }
    progressLoading();
    setTimeout(function(){
        $(document).ready(function() { $.LoadingOverlay('hide'); });
        jQuery('body').addClass('bg-infinity');
    }, <?php echo get_option('_crb_lama_loading'); ?>);
</script>
<!-- CSS Begins-->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/flaticon.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/bootstrap.part1.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/bootstrap.part2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/portfolio.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/animate.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/tweet-carousel.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/vegas.min.css" rel="stylesheet" type="text/css" />
<!-- Main Style -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/responsive.css" rel="stylesheet" type="text/css /">
<!-- Color Panel -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/color_panel.css" rel="stylesheet" type="text/css /">
<!-- Skin Colors -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/landing.css" id="changeable-colors" rel="stylesheet" type="text/css" />
<!-- Custom Styles -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/parallax-star.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/floating-cloud.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/infinity.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/bgsliding.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .page-title {
        background-image:
            linear-gradient(rgb(14 66 95 / 90%), rgb(32 79 105 / 60%)),
            url(https://images.unsplash.com/photo-1492546643178-96d64f3fd824?auto=format&fit=crop&w=1051&q=25)
            !important;
    }
    .bg-overlay.pattern {
        background:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        filter:progid: DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#7c000000',endColorstr='#7c000000');
        /* IE */
    }
    .navbar ul.nav a {
        text-decoration: none;
    }
    h3.normal {
        font-weight: bold;
        font-size: 15px;
    }
    .factor {
        word-break: break-all;
    }
    .navbar-fixed-bottom .navbar-collapse, .navbar-fixed-top .navbar-collapse {
        max-height: inherit;
    }
    .container > div.row > div.text-center {
        margin-top: 0;
    }
    .counting-box > div {
        margin-bottom: 45px;
    }
    .setbulet {
        padding: 15px;
        width: 88px;
        margin: auto;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: inset 0 0 4px #2e3642;
    }
    .setbulet img{
        height: 60px;
        width: 60px;
    }
    .text-shadow {
        text-shadow: 2px 2px 4px #000000;
    }
    .text-xbold {
        font-weight: bold;
    }
    .text-white {
        color: #fff;
    }
    .intro-text h1 {
        font-size: 40px;
        color: #fff;
    }
    .pull-up {
        transition: all 0.25s ease; 
    }
    .pull-up:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0px 14px 24px rgb(62 57 107 / 20%);
        z-index: 999;
        box-shadow: inset 0 0 4px #2e3642;
    }
</style>
<section id="sewa_aset">
    <div class="container intro-text">
        <div class="row text-center">
            <div class="col-md-12" style="margin-top: 35px;">
                <a class="main animated" data-animation="fadeInTop" data-animation-delay="1000" href="<?php echo site_url(); ?>">
                    <img class="site-logo" src="<?php echo get_option('_crb_menu_logo_dashboard'); ?>" alt="SIMATA" />
                </a>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-12">
                <div class="main animated" data-animation="fadeInTop" data-animation-delay="1000">
                    <h1 class="text-shadow" style="padding-top: 0 !important;padding-bottom: 50px; margin-top: 20px !important;"><?php echo get_option('_crb_judul_header'); ?></h1>
                </div>
            </div>
        </div>
        <div class="row counting-box title-row text-center">
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInLeft" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_1'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_1'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_1'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_1'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInLeft" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_2'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_2'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_2'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_2'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInTop" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_3'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_3'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_3'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_3'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInTop" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_4'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_4'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_4'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_4'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInRight" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_5'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_5'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_5'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_5'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInRight" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_6'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_6'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_6'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_6'); ?></h3>
                </a>
            </div>
        </div>
        <div class="row counting-box text-center title-row">
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInLeft" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_7'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_7'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_7'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_7'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInLeft" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_8'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_8'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_8'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_8'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInBottom" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_9'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_9'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_9'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_9'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInBottom" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_10'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_10'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_10'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_10'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInRight" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_11'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_11'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_11'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_11'); ?></h3>
                </a>
            </div>
            <div class="col-md-2 col-xs-6 animated" data-animation="fadeInRight" data-animation-delay="1000">
                <div class="setbulet bg-info pull-up">
                    <a href="<?php echo get_option('_crb_menu_url_12'); ?>" target="_blank">
                        <img src="<?php echo get_option('_crb_menu_logo_12'); ?>">
                    </a>
                </div>
                <a href="<?php echo get_option('_crb_menu_url_12'); ?>" target="_blank">
                    <h3 class="normal text-white text-xbold text-shadow"><?php echo get_option('_crb_menu_text_12'); ?></h3>
                </a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.sticky.js"></script>
<!-- Slider and Features Canvas -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/vegas.min.js"></script>
<!-- Overlay -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/modernizr.js"></script>
<!-- Screenshot -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.flexisel.js"></script>
<!-- Portfolio -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.easing.1.3.js"></script>
<!-- Counting Section -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/jquery.appear.js"></script>
<!-- Expertise Circular Progress Bar -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/effect.js"></script>
<!-- Twitter -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/carousel.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/custom.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/delaunator.min.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/rainbow-lines.js"></script>
<!-- Color -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/color-panel.js"></script>
<script type="text/javascript">
<?php
    $background_header_db = $this->functions->get_option_complex('_crb_background_beranda', 'beranda');
    $background_header = array();
    foreach($background_header_db as $background){
        $background_header[] = array('src' => $background['gambar']);
    }
    echo 'var background_header = '.json_encode($background_header).';';
?>
    $('body').vegas({
        slides: background_header
    });
</script>