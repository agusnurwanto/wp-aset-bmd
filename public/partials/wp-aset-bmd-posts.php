<!-- CSS Begins-->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/flaticon.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/bootstrap.part1.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/bootstrap.part2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/tweet-carousel.css" rel="stylesheet" type="text/css" />
<!-- Main Style -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/responsive.css" rel="stylesheet" type="text/css /">
<!-- Color Panel -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/color_panel.css" rel="stylesheet" type="text/css /">
<!-- Skin Colors -->
<link href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>/css/landing.css" id="changeable-colors" rel="stylesheet" type="text/css" />
<!-- Custom Styles -->
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
</style>

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
</script>