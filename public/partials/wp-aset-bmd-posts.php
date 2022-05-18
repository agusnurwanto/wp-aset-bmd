<?php
    $link_dashboard = $this->functions->generatePage(array(
        'nama_page' => 'Dasboard Aset Pemerintah Daerah',
        'content' => '[dashboard_aset_pemda]',
        'show_header' => 1,
        'no_key' => 1,
        'update' => 0,
        'post_status' => 'publish'
    ));
    $link_dashboard_sewa = $this->functions->generatePage(array(
        'nama_page' => 'Data Aset Yang Disewakan',
        'content' => '[dashboard_aset_disewakan]',
        'show_header' => 1,
        'no_key' => 1,
        'post_status' => 'publish'
    ));
    $link_dashboard_potensi_sewa = $this->functions->generatePage(array(
        'nama_page' => 'Data Potensi Aset Yang Disewakan',
        'content' => '[dashboard_aset_disewakan potensi="1"]',
        'show_header' => 1,
        'no_key' => 1,
        'post_status' => 'publish'
    ));
    $link_dashboard_tanah = $this->functions->generatePage(array(
        'nama_page' => 'Data Aset Tanah',
        'content' => '[dashboard_aset_tanah]',
        'show_header' => 1,
        'no_key' => 1,
        'post_status' => 'publish'
    ));     
?>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/js/loadingoverlay.min.js"></script>
<script type="text/javascript">
    window.total_per_jenis = <?php echo get_option('_crb_total_per_jenis'); ?>;
    window.chart_jenis_aset = {
        label : [],
        data : [],
        color : [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ]
    };
    total_per_jenis.map(function(b, i){
        chart_jenis_aset.label.push(b.nama);
        chart_jenis_aset.data.push(b.total);
    });
    window.total_per_bidang = <?php echo get_option('_crb_total_per_bidang'); ?>;
    var $ = jQuery;
    function siteUrl(){ 
        return "<?php echo plugin_dir_url(dirname(__FILE__)); ?>"; 
    }
    function progressLoading( $onlyload = false ) {
        $.LoadingOverlay('show', { 
            image : '', 
            custom : '<video style="position: absolute; width: 100%; top: 0" autoplay muted><source src="'.get_option('_crb_menu_video_loading').'" type="video/mp4">Your browser does not support the video tag.</video>', 
            imageAnimation : false,
            background : "rgba(0, 0, 0, 1)" 
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
        /*background-image: url(<?php echo get_option('_crb_background_pratinjau'); ?>) !important;
        background-attachment:fixed;
        background-size:cover;
        -o-background-size:cover;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        background-repeat: no-repeat !important;*/
        color:#ffffff;
        text-align:center;
    }
    #demo-video {
        background-image: url(<?php echo get_option('_crb_background_video'); ?>) !important;
        background-repeat: no-repeat !important;
    }
    .navbar ul.nav a {
        text-decoration: none;
    }
    h3.normal {
        font-weight: bold;
        font-size: 25px;
    }
    .factor {
        word-break: break-all;
    }
    .navbar-fixed-bottom .navbar-collapse, .navbar-fixed-top .navbar-collapse {
        max-height: inherit;
    }
</style>
<header id="header">
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>
    <div id="navigation-sticky-wrapper" class="sticky-wrapper" style="height: 110px;">
        <div class="navbar navbar-fixed-top" id="navigation">
            <div class="container" style="flex-wrap: nowrap; display: block;">
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
                    <ul class="nav navbar-nav navbar-right" style="flex-wrap: nowrap; display: block; margin-left: 0px;">
                        <?php echo get_option('_crb_menu_kanan'); ?>
                    </ul>
                </nav>
                <!-- End Navigation Menu -->
            </div>
            <!-- End container -->
        </div>
    </div>
</header>

<!-- Blog Section Begins-->
<section id="blog" class="blog">
        <div class="container blog-inner">
        	<!--<canvas id="c" class="rainbowbg rainbowcover" width="" height=""></canvas>-->
            <!-- Title & Desc Row Begins -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Title -->
                    <div class="title">
                        <h2><span><?php echo get_option('_crb_judul_blog'); ?></span></h2>
                    </div>
                </div>
            </div>
            <!-- Title & Desc Row Ends -->
            <!-- Blog Inner Begins -->
            <div class="blog-scroll-section">

                
                <?php
                    $kategori = strtolower(get_option('_crb_kategori_blog'));
                    // get data posts
                    $the_query = new WP_Query( array(
                        'numberposts'      	=> -1,
                        'post_type' => 'post',
                        'category_name' => $kategori,
                    )); 

                    if ( $the_query->have_posts() ): 
                        while ( $the_query->have_posts() ) : $the_query->the_post();
                            if( is_singular() && post_type_supports( get_post_type(), 'comments' ) ):
                                // Remove the comment form
                                add_filter( 'comments_open', '__return_false' ); 
                                // Remove the list of comments
                                add_filter( 'comments_array', '__return_empty_array' );
                                // $id = the_ID();
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' ); 
                                if(!empty($image)):
                                    $image = $image[0];
                                else:
                                    $image = plugin_dir_url(dirname(__FILE__)).'/images/no-image.jpg';
                                endif;
                ?>
                        <div class="col-md-4 animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="400">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <img class="blog-img img-responsive" alt="<?php echo the_title(); ?>" src="<?php echo $image; ?>">
                                </div>
                                <div class="panel-body">
                                    <a href="<?php echo get_post_permalink(); ?>">
                                        <h3><?php echo the_title(); ?></h3>
                                    </a>
                                    <p>
                                        <span class="label label-default">Gallery</span>
                                        <span><i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date('l j F Y'); ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                <?php
                            endif;
                        endwhile;
                    endif;
                ?>
            </div>
            <!-- Blog Inner Ends -->
        </div>
        <!-- Container Ends -->
    </section>
<!-- Blog Section Ends-->

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

    cek_click = false;
    $('html').on('click', function(){
        play_video();
    });
    function play_video() {
        if(!cek_click){
            console.log('play_video!');
            cek_click = true;
            var src = $('#video-demo').attr('data-src');
            if(src){
                setTimeout(function(){
                    $('#video-demo').attr('src', src);
                }, 1000);
            }
        }
    }
    if(pieChart2){
        var new_data = [];
        var labels = [];
        for(var i in total_per_bidang){
            labels.push(total_per_bidang[i].nama.substring(0, 50));
            new_data.push(total_per_bidang[i].total);
        };
        if(new_data.length == labels.length){
            pieChart2.data.labels = labels;
            pieChart2.data.datasets[0].data = new_data;
            pieChart2.update();
        }
    }
</script>