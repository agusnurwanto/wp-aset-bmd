<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/loadingoverlay.min.js"></script>
<script type="text/javascript">
    var $ = jQuery;
    function siteUrl(){ 
        return "<?php echo plugin_dir_url(dirname(__FILE__)); ?>"; 
    }
    function progressLoading( $onlyload = false ) {
        $.LoadingOverlay('show', { 
            image : '<?php echo get_option('_crb_menu_logo_loading'); ?>', 
            imageAnimation : false,
            background : "rgba(255, 255, 255, 1)" 
        });
        if ( $onlyload === false ) {
            $(document).ready(function() { $.LoadingOverlay('hide'); });
        }
    }
    progressLoading();
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
    .intro-text h1, .title h2 {
        color: #fff;
    }
    /* Header section */
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
    /* ------------- Sticky Container ------------- */
    header .sticky-wrapper.is-sticky .navbar,#pages header .sticky-wrapper .navbar {
        z-index:1001;
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.7);
    }
    header .dropdown-menu {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.7);
    }
    header .navbar-collapse.collapse.in{
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.7);
    }
    .welcome-section i {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.5);
        padding:25px;
        border-radius:50%;
        color:#ffffff;
        margin-bottom:30px;
    }
    .counting-box i {
        color:#ffffff;
        width:110px;
        height:110px;
        line-height:110px;
        border-radius:50%;
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.5);
        margin-bottom:20px;
        margin-top:20px;
    }
    .video_bg {
        background:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/video_bg.png) no-repeat center 100%;
        background-size:100%;
        max-width:700px;
        margin:0px auto;
        position:relative;
        padding:70px 0px 60px 0;
        margin-bottom:-30px;
        z-index:10;
    }
    .blog .load-post .btn {
                background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.5);
        padding:15px 25px;
            color:#FFFFFF;
    }
    .clients .client-logo .logo-top img,.clients .client-logo .logo-bottom img {
            filter:url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.9999 0.9999 0 1 0\'/></filter></svg>#grayscale");
        /* for Webkit browsere,Chrome 19+,Safari 6+... */   -webkit-filter:grayscale(0.5);
             /* for IE6+*/   -moz-filter:grayscale(0.5);
             -ms-filter:grayscale(0.5);
             -o-filter:grayscale(0.5);
             filter:grayscale(0.5);
             opacity:0.65;
             filter:gray;
    }
    .clients .client-logo .logo-top img:hover,.clients .client-logo .logo-bottom img:hover {
        filter:url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'1 0 0,1 0\'/></filter></svg>#grayscale");
            /* for Webkit browsere,Chrome 19+,Safari 6+... */   -webkit-filter:grayscale(0);
            /* for IE6+*/   filter:gray;
            opacity:1;
        -moz-filter:grayscale(0);
            -ms-filter:grayscale(0);
            -o-filter:grayscale(0);
            filter: grayscale(0);
    }
    .contact .form-control {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.8);
        opacity:0.60;
        color:#ffffff !important;
        border:1px solid #000000;
        height:60px;
        border-radius:3px;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
        -ms-border-radius:3px;
    }
    .download-now {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.8);
        position:relative;
    }
    .copyright {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/pattern.png);
        background-color:rgba(0,0,0,.8);
        color:#FFFFFF;
        position:relative;
    }
    #additional {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/additional-bg.jpg);
         background-attachment:fixed !important;
         background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat:repeat;
        color:#ffffff;
    }
    #screenshots {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/screens-bg.jpg);
         background-attachment:fixed;
         background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat:repeat;
        color:#ffffff;
        text-align:center;
    }
    #demo-video {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/video-bg.jpg);
         background-attachment:fixed !important;
         background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat:repeat;
        color:#ffffff;
    }
    #team {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/team-bg.jpg);
         background-attachment:fixed !important;
         background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat:repeat;
        color:#ffffff;
    }
    #subscribe {
        background-image:url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/subscribe-bg.jpg);
         background-attachment:fixed !important;
         background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat:repeat;
        color:#ffffff;
    }
    #team {
        background-image: url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/_tim_bg.jpg) !important;
        background-repeat: no-repeat !important;
    }
    #copyright {
        background: url(<?php echo plugin_dir_url(dirname(__FILE__)); ?>images/bg_footer.jpg) !important;
        background-attachment: fixed !important;
        background-size: cover !important;
        -o-background-size: cover !important;
        -moz-background-size: cover !important;
        -webkit-background-size: cover !important;
        background-repeat: no-repeat !important;
    }
    #fitur {
        background-image: url(<?php echo get_option('_crb_background_fitur'); ?>) !important;
        background-attachment:fixed !important;
        background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat: no-repeat !important;
        color:#ffffff;
    }
    #pratinjau {
        background-image: url(<?php echo get_option('_crb_background_pratinjau'); ?>) !important;
        background-attachment:fixed;
        background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat: no-repeat !important;
        color:#ffffff;
        text-align:center;
    }
    #demo-video {
        background-image: url(<?php echo get_option('_crb_background_video'); ?>) !important;
        background-repeat: no-repeat !important;
    }
</style>
<header id="header">
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>
    <div class="bg-overlay pattern "></div>
    <div id="navigation-sticky-wrapper" class="sticky-wrapper" style="height: 110px;">
        <div class="navbar navbar-fixed-top" id="navigation">
            <div class="container" style="flex-wrap: nowrap;">
                <!-- Navigation Bar -->
                <div class="navbar-header">
                    <!-- Responsive Menu Button -->
                    <button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button"
                        class="navbar-toggle">
                        <span class="sr-only">Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Logo Image -->
                    <a href="<?php echo site_url(); ?>" class="navbar-brand" style="height: 70px;">
                        <img class="site-logo" src="<?php echo get_option('_crb_menu_logo'); ?>" alt="SIMATA" />
                    </a>
                </div>
                <nav id="topnav" role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
                    <ul class="nav navbar-right">
                        <?php echo get_option('_crb_menu_kanan'); ?>
                    </ul>
                </nav>
                <!-- End Navigation Menu -->
            </div>
            <!-- End container -->
        </div>
    </div>
    <div class="container intro">
        <div class="row">
            <div class="col-md-7 intro-text">
                <!-- TEXT -->
                <div class="main animated" data-animation="fadeInLeft" data-animation-delay="200">
                    <h1><?php echo get_option('_crb_judul_header_1'); ?></h1>
                </div>
                <p class="medium_white_light animated" data-animation="fadeInLeft" data-animation-delay="300"><?php echo get_option('_crb_text_header_1'); ?></p>
                <div class="animated" data-animation="fadeInUp" data-animation-delay="400">
                    <?php echo get_option('_crb_tombol_header_1'); ?>
                </div>
            </div>
            <div class="col-md-5 intro-image animated hidden-sm" data-animation="fadeInRight" data-animation-delay="100">
                <!-- Image -->
                <a href="#beranda" class="imglink slide-btn">
                    <img src="<?php echo get_option('_crb_img_header_1'); ?>" alt="SIMATA" class="img-responsive" />
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Testimonials Section Begins -->
<section id="testimoni" class="testimonials">
    <div class="container testimonials-inner">
        <div id="feedback">
        <?php
            $testimonial = $this->functions->get_option_complex('_crb_testimoni', 'testimoni');
            foreach($testimonial as $testi){
                echo '
                    <div class="row">
                        <div class="col-md-9 animated" data-animation="fadeInUp" data-animation-delay="100">
                            <div class="feedback">
                                <div class="bg-text" data-bg-text="Testimoni">
                                    <p>'.$testi['pesan'].'</p>
                                </div>
                                <!-- Name -->
                                <h3 class="italic">'.$testi['nama'].'</h3>
                            </div>
                        </div>
                        <div class="col-md-3 hidden-sm hidden-xs">
                            <!-- Image -->
                            <img src="'.$testi['gambar'].'" alt="" class="img-responsive" />
                        </div>
                    </div>
                ';
            }
        ?>
        </div>
    </div>
</section>
<!-- Testimonials Section Ends -->

<!-- Features Section Begins -->
<section id="fitur">
    <div class="features-section">
        <div class="bg-overlay pattern"></div>
        <div class="container features-inner">
            <!-- Title & Desc Row Begins -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Title -->
                    <div class="title">
                        <h2><?php echo get_option('_crb_judul_fitur'); ?></h2>
                    </div>
                </div>
            </div>
            <!-- Title & Desc Row Ends -->
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <ul class="features-list features-list-left">
                    <?php
                        for($i=1; $i<=3; $i++){
                            $icon = get_option('_crb_fitur_icon'.$i);
                            if(!empty($icon)){
                                echo '
                                <li class="features-list-item animated" data-animation="fadeInLeft"
                                    data-animation-delay="500">
                                    '.$icon.'
                                    <div class="features-content">
                                        <h3>'.get_option('_crb_fitur_judul'.$i).'</h3>
                                        '.get_option('_crb_fitur_pesan'.$i).'
                                    </div>
                                </li>';
                            }
                        }
                    ?>
                    </ul>
                </div>
                <!-- FEATURES RIGHT -->
                <div class="col-md-4 col-md-push-4 col-sm-6">
                    <ul class="features-list features-list-right">
                    <?php
                        for($i=4; $i<=6; $i++){
                            $icon = get_option('_crb_fitur_icon'.$i);
                            if(!empty($icon)){
                                echo '
                                <li class="features-list-item animated" data-animation="fadeInLeft"
                                    data-animation-delay="500">
                                    '.$icon.'
                                    <div class="features-content">
                                        <h3>'.get_option('_crb_fitur_judul'.$i).'</h3>
                                        '.get_option('_crb_fitur_pesan'.$i).'
                                    </div>
                                </li>';
                            }
                        }
                    ?>
                    </ul>
                </div>
                <!-- CLOSE UP SIMATA -->
                <div class="col-md-4 col-md-pull-4 app-image animated hidden-sm hidden-xs" data-animation="fadeInUp"
                    data-animation-delay="300">
                    <a href="#fitur" class="imglink slide-btn">
                        <img src="<?php echo get_option('_crb_gambar_fitur'); ?>" alt="SIMATA" class="img-responsive" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features Section Ends -->

<!-- Screenshot Section -->
<section id="pratinjau">
    <div class="screenshots">
        <div class="bg-overlay pattern"></div>
        <div class="container screenshots-inner">
            <!-- Title & Desc Row Begins -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Title -->
                    <div class="title">
                        <h2><?php echo get_option('_crb_judul_pratinjau'); ?></h2>
                    </div>
                </div>
            </div>
            <!-- Title & Desc Row Ends -->
            <!-- Screenshots List -->
            <div id="screenshot" class="effects clearfix effect2 animated" data-animation="fadeInUp" data-animation-delay="300">
            <?php
                $gambar_pratinjau = $this->functions->get_option_complex('_crb_pratinjau', 'gambar');
                foreach($gambar_pratinjau as $val){
                    echo '
                        <div class="screen-img">
                            <div class="img">
                                <!-- Image -->
                                <img src="'.$val['gambar'].'" alt="" class="img-responsive" />
                                <div class="overlay">
                                    <!-- Overlay Image -->
                                    <a href="'.$val['gambar'].'" data-rel="prettyPhoto[gallery]" class="expand">+</a>
                                    <a class="close-overlay hidden">x</a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
</section>
<!-- End Screenshot Section -->

<!-- Demo Video Section -->
<section id="demo-video">
    <div class="demo-video">
        <div class="bg-overlay pattern"></div>
        <div class="container demo-video-inner text-center">
            <!-- Title & Desc Row Begins -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Title -->
                    <div class="title">
                        <h2><?php echo get_option('_crb_judul_video'); ?></h2>
                    </div>
                </div>
            </div>
            <!-- Title & Desc Row Ends -->
            <div class="video_bg animated" data-animated="fadeInUp" data-animation-delay="200">
                <iframe id="video-demo" src="<?php echo get_option('_crb_video_demo'); ?>" width="640" height="360"></iframe>
            </div>
        </div>
    </div>
</section>
<!-- End Demo Video Section -->

<!-- Monitoring Section Begins -->
<section id="monitoring" class="counting bg-infinity">
    <div class="container counting-inner">
        <!-- Title & Desc Row Begins -->
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- Title -->
                <div class="title">
                    <h2><?php echo get_option('_crb_judul_monitoring'); ?></h2>
                </div>
            </div>
        </div>
        <!-- Monitoring Row Begins -->
        <div class="container counting-inner">
            <!-- Counting Row Begins -->
            <div class="row counting-box title-row" style="margin-bottom: 75px;">
                <!-- Counting Box 1 Begins -->
                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                	data-animation-delay="100">
                    <!-- Icon -->
                    <i class="fa fa-money fa-3x" style="background-color: #34b677"></i>
                    <!-- Title -->
                    <h3 class="normal">Total Nilai Barang Milik Daerah</h3>
                    <!-- Count Number -->
                    <div id="statAkses">
                        <div class="factor" style="color: #258154"><?php echo number_format(get_option('_crb_total_nilai'), 2, ',', '.'); ?></div>
                    </div>
                </div>
                <!-- Counting Table 1 Ends -->
            </div>
            <div class="row counting-box title-row">
                <!-- Counting Table 2 Begins -->
                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                    data-animation-delay="200">
                    <!-- Icon -->
                    <i class="fa fa-users fa-3x" style="background-color: #6d46bb"></i>
                    <!-- Title -->
                    <h3 class="normal">Jumlah Sub Unit Pengelola Aset</h3>
                    <!-- Count Number -->
                    <div class="fact-number" id="statUser" data-perc="<?php echo get_option('_crb_jumlah_sub_unit'); ?>">
                        <div class="factor" style="color: #5e3aa9"></div>
                    </div>
                </div>
            </div>
            <!-- Counting Row Ends -->
        </div>
        <!-- Monitoring Row Ends -->
    </div>
    <!-- Container Ends -->
</section>
<!-- Monitoring Section Ends -->
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
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/scripts.js"></script>
<!-- <script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/tweetie.min.js"></script> -->
<!-- Custom -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/custom.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/delaunator.min.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/rainbow-lines.js"></script>
<!-- Color -->
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/color-panel.js"></script>
<script type="text/javascript">
<?php
    $background_header_db = $this->functions->get_option_complex('_crb_background', 'header_utama');
    $background_header = array();
    foreach($background_header_db as $background){
        $background_header[] = array('src' => $background['gambar']);
    }
    echo 'var background_header = '.json_encode($background_header).';';
?>
    var windowW = window.innerWidth;
    var windowH = window.innerHeight;
    // console.log(windowW+'x'+windowH);
    $('#beranda header, .container.intro')
    .css( 'min-height', windowH + 'px' );

    $('#header').vegas({
        slides: background_header
    });

    $('[data-toggle="tooltip"]').tooltip();

    if (window.matchMedia('(min-width: 767px)').matches) {
        $('.contact').vegas({
            slides: [
                { src: siteUrl() +'/images/bg_kontak.jpg', delay: 1000 * 3 },
                { src: siteUrl() +'/images/bg_kontak2.jpg', delay: 1000 * 7 },
            ]
        });
    } else {
        $('.contact').vegas({
            slides: [
                { src: siteUrl() +'/images/bg_kontak_dark.jpg', delay: 1000 * 10 },
            ]
        });
    }

    function urlFileDown(url, filename = '', entity = '', target = '', uT = '', uI = '', dT = '', dI = '') {
        var element = document.createElement('a');
        element.style.display = 'none';
        element.setAttribute('href', url);
        element.setAttribute('download', filename);
        element.setAttribute('target', target);
        document.body.appendChild(element);

        var counter = {
            "url": apiUrl() +"download/counter", "method": "POST", "timeout": 0,
            "headers": { "Content-Type": "application/x-www-form-urlencoded" },
            "data": { "user_type": uT, "user_id": uI, "dl_type": dT, "dl_id": dI },
        };

        swal({
            title: "Mohon tunggu!",
            text: "Proses unduh "+ entity,
            icon: "warning",
            button: "OK",
        })
        .then( (value) => {
            element.click(); progressLoading(true);
            document.body.removeChild(element);
            $.ajax(counter).done( function(response) {});
            setTimeout(function() { $.LoadingOverlay('hide'); }, 1000 * 3);
            setInterval(function() { console.clear(); }, 1000 * 6);
        });
    }

    function togglePanelIcon(e) {
        $(e.target)
            .prev('.panel-heading').find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }

    $('.panel-group').on('hidden.bs.collapse', togglePanelIcon);
    $('.panel-group').on('shown.bs.collapse', togglePanelIcon);

    $('#popAnnounce').modal('show');
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]',
        trigger: 'hover focus',
        container: 'body',
    });
    $("body").popover({
        selector: '[data-toggle="popover"]',
        trigger: 'hover focus',
        container: 'body',
    });
    setTimeout(function(){
        $('.stars3').after(''
            +'<div id="Clouds">'
                +'<div class="Cloud Foreground"></div>'
                +'<div class="Cloud Background"></div>'
                +'<div class="Cloud Foreground"></div>'
                +'<div class="Cloud Background"></div>'
                +'<div class="Cloud Foreground"></div>'
                +'<div class="Cloud Background"></div>'
                +'<div class="Cloud Background"></div>'
                +'<div class="Cloud Foreground"></div>'
                +'<div class="Cloud Background"></div>'
                +'<div class="Cloud Background"></div>'
            +'</div>'
        +'');
    }, 1000);
    $('#topnav ul li a').on('click', function(){
        $(this).closest('ul').find('li').removeClass('active');
        $(this).closest('li').addClass('active');
    });
</script>