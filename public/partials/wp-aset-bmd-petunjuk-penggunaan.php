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
        margin-bottom: 7px;
    }
    .factor {
        word-break: break-all;
    }
    .navbar-fixed-bottom .navbar-collapse, .navbar-fixed-top .navbar-collapse {
        max-height: inherit;
    }
    .container > div.row > div.text-center {
        margin-top: 0 !important;
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
    .keterangan {
        margin-bottom: 45px;
    }
</style>
<section id="sewa_aset">
    <div class="container intro-text">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="main animated" data-animation="fadeInTop" data-animation-delay="1000">
                    <h1 style="padding-top: 0 !important;padding-bottom: 50px; margin-top: 20px !important;">Petunjuk Penggunaan</h1>
                </div>
            </div>
        </div>
    <?php
        for($i=1; $i<=7; $i++){
            $n = $i*2;
            $_n = $n-1;
            echo '
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="setbulet bg-info pull-up">
                            <img src="'.get_option('_crb_menu_logo_'.$_n).'">
                        </div>
                        <h3 class="normal text-white text-xbold text-shadow">'.get_option('_crb_menu_text_'.$_n).'</h3>
                        <div class="normal keterangan text-left">
                            '.get_option('_crb_menu_keterangan_'.$_n).'
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="setbulet bg-info pull-up">
                            <img src="'.get_option('_crb_menu_logo_'.$n).'">
                        </div>
                        <h3 class="normal text-white text-xbold text-shadow">'.get_option('_crb_menu_text_'.$n).'</h3>
                        <div class="normal keterangan text-left">
                            '.get_option('_crb_menu_keterangan_'.$n).'
                        </div>
                    </div>
                </div>';
        }
    ?>
    </div>
</section>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/vegas.min.js"></script>