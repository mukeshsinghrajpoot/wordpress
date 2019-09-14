<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Medical_Heed
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function medical_heed_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'medical_heed_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function medical_heed_pingback_header() {

	if ( is_singular() && pings_open() ) {

		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'medical_heed_pingback_header' );

/**
 * Breadcrumbs.
 */
if( !function_exists('medical_heed_breadcrumbs') ) :

    function medical_heed_breadcrumbs(){ ?>

        <section class="breadcrumb">
            <div class="container">
                <?php
                    if( is_single() || is_page() ) {

                        the_title( '<h1 class="entry-title">', '</h1>' );

                    } elseif( is_archive() ) {

                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="taxonomy-description">', '</div>' );

                    } elseif( is_search() ) { ?>

                        <h1 class="page-title">
                            <?php printf( esc_html_e( 'Search Results for: %s', 'medical-heed' ), '<span>' . get_search_query() . '</span>' ); ?>
                        </h1>

                    <?php } elseif( is_404() ) {

                        echo '<h1 class="entry-title">'. esc_html( '404 Error', 'medical-heed' ) .'</h1>';

                    } elseif( is_home() ) {

                        $page_for_posts_id = get_option( 'page_for_posts' );
                        $page_title = get_the_title( $page_for_posts_id );
                    ?>
                        <h1 class="entry-title"><?php echo esc_html( $page_title ); ?></h1>

                <?php } ?>

                <nav id="breadcrumb" class="medical-heed-breadcrumb">
                    <?php
                       breadcrumb_trail ( array(
                         'container'   => 'div',
                         'show_browse' => false,
                       ) );
                    ?>
                </nav>        
            </div>
        </section>

    <?php }

endif;
add_action ('medical_heed_action_breadcrumbs','medical_heed_breadcrumbs',200);

/**
 * Banner Slider Section Area
 */
function medical_heed_featured_slider(){ ?>

    <div id="home" class="home-section banner-height">
        <div class="banner-slider">
            <ul class="slides">
                <?php 
                    $pages = array();
                    for ( $count = 1; $count <= 4; $count++ ) {

                        $slider = get_theme_mod( 'medical_heed_slider' . $count );

                        if ( 'page-none-selected' != $slider ) {
                            $pages[] = $slider;
                        }
                    }

                    $args = array(
                        'posts_per_page' => 4,
                        'post_type'      => 'page',
                        'post__in'       => $pages,
                    );

                    $query = new WP_Query( $args );

                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

                    $image_path = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medical-head-image-size', true );
                ?>
                    <li class="bg-dark" style="background-image: url('<?php echo esc_url($image_path[0]); ?>');">
                        <div class="home-slider-overlay"></div>
                        <div class="banner-caption">
                            <div class="caption-content">
                                <div class="banner-title"><?php the_title(); ?></div>
                                <div class="banner-desc"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php echo esc_html_e('Read More','medical-heed'); ?>       
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endwhile; endif; wp_reset_postdata(); ?>
            </ul>
        </div>
    </div>
	<?php }

add_action('medical_heed_action_slider','medical_heed_featured_slider',20);


/**
 * Featured Services Area
 */
function medical_heed_features_services_area(){ 

    $fservices = get_theme_mod('medical_heed_features_services_options');

    if( !empty( $fservices ) ){
        ?>
        <section class="featuresarea">
            <div class="container">
                <?php 
                    $fservices_pages = json_decode( $fservices );
                    
                    foreach( $fservices_pages as $fservices_page ) : 

                        $page_id = $fservices_page->service_page;
                         
                    if( !empty( $page_id ) ) :

                    $fservice_query = new WP_Query( 'page_id='.$page_id ); 

                        if( $fservice_query->have_posts() ) : while( $fservice_query->have_posts() ): $fservice_query->the_post();

                ?>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 feature-wrap">
                        <div class="feature-box-inner">

                            <?php if ( ! empty ($fservices_page->icons) ){ ?>
                                <div class="feature-box-icon"> 
                                    <i class="fab <?php echo esc_html($fservices_page->icons ); ?>"></i>
                                </div> 
                            <?php } ?>
                            
                            <h3 class="feature-box-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                            <div class="feature-box-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>

                <?php endwhile; endif; wp_reset_postdata();  endif; endforeach; ?>
            </div>
        </section>

    <?php } }

add_action('medical_heed_features_services','medical_heed_features_services_area',25);

/**
 * Features Promo Section Area
*/
function medical_heed_popular_for(){

    $title = get_theme_mod('medical_heed_popular_title');
    $description = get_theme_mod('medical_heed_popular_description'); ?>

	<section class="promotion">
        <div class="container">
            <?php  if (!empty( $title ) || !empty( $description ) ) { ?>
                <div class="row">
                    <div class="col-lg-12 sectiontitle">
                        <?php if (!empty ($title)) : ?>

                                <h1><?php echo esc_html($title); ?></h1>

                        <?php endif; if (!empty($description )) : ?>

                                <p><?php echo esc_html($description); ?></p>

                        <?php  endif; ?>
                    </div>
                </div>

            <?php } 

                $pages = array();

                for ( $count = 1; $count <= 5; $count++ ) {

                    $mod = get_theme_mod( 'medical_heed_popular_img' . $count );

                    if ( 'page-none-selected' != $mod ) {
                        $pages[] = $mod;
                    }
                }

                $args = array(
                    'posts_per_page' => 5,
                    'post_type' => 'page',
                    'post__in' => $pages,
                    'orderby' => 'post__in'
                );

                $query = new WP_Query( $args ); 
            ?>
            <div class="row">
                <?php
                    $count = 1; 
                    while ( $query->have_posts() ) : $query->the_post();

                    if( $count <= 3){
                        $colid = 4;
                    }else{
                        $colid = 6;
                    }
                ?>
                    <div class="col-lg-<?php echo intval( $colid ); ?> col-md-<?php echo intval( $colid ); ?> col-sm-6 col-xs-12">
                        <figure class="medic-effect">
                            <?php the_post_thumbnail('medical-head-about-image'); ?>
                            <figcaption>
                                <div>
                                    <h2>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                <?php $count++; endwhile; ?>
            </div>
    </section>
	<?php } 
add_action('medical_heed_action_popular','medical_heed_popular_for',30);

/**
 * Section Treatment.
 */
function medical_heed_treatment(){

    $page  = get_theme_mod('medical_heed_treatment');
    $image = get_theme_mod('medical_heed_treatment_image');

    if (!empty ($page)) { ?>

	<section class="about-us">
        <div class="container">
            <?php 
                $args = array(
                    'posts_per_page' => 1,
                    'post_type'      => 'page',
                    'page_id'        => absint( $page ),
                    'post_status'    => 'publish',
                );

                 $query = new WP_Query( $args );

                 if ($query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
            ?>
                <div class="row">
                    <div class="col-lg-6  col-md-6  col-sm-12">
                        <?php if ($image ) { ?>
                            <figure>
                                <img src="<?php echo esc_url( wp_get_attachment_url( $image ) ); ?>">
                            </figure>

                        <?php } else { ?>
                                <figure>
                                    <?php the_post_thumbnail('medical-head-about-image'); ?>
                                </figure>
                        <?php } ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <?php
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'medical-heed' ),
                                'after'  => '</div>',
                            ) );
                        ?>
                    </div>

                </div><!-- row -->

            <?php endwhile; endif; ?>

        </div>

    </section>
	<?php } }
add_action('medical_heed_action_treatment','medical_heed_treatment',45);

/**
 * Section Facility.
*/
function medical_heed_facility(){
	$title     = get_theme_mod('medical_heed_facility_title');
	$subtitle  = get_theme_mod('medical_heed_facility_subtitle');
    $service_page = get_theme_mod('medical_heed_facility_icons');
   
	?>
	<section class="facilities">
        <div class="container">
            <?php if (!empty( $title ) || !empty( $subtitle ) ) { ?>
                <div class="row">
                    <div class="col-lg-12 sectiontitle">
                    	<?php  if (!empty ($title)) : ?>

                    		<h2><?php echo esc_html($title); ?></h2>

                    	<?php endif; if (!empty ($subtitle)) : ?>

                    			<p><?php echo esc_html($subtitle); ?></p>

                    	<?php endif; ?>
                    </div>
                </div>
            <?php } ?>

            <div class="row">
                <?php 
                    if( !empty( $service_page ) ):

                    $service_pages = json_decode( $service_page );
                    
                    foreach( $service_pages as $service_page ) : 

                        $page_id = $service_page->service_page;
                         
                    if( !empty( $page_id ) ) :

                    $service_query = new WP_Query( 'page_id='.$page_id ); 

                        if( $service_query->have_posts() ) : while( $service_query->have_posts() ): $service_query->the_post();

                ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 box">

                        <?php if ( ! empty ($service_page->icons) ){ ?>
                            <div class="service-icon">
                                <a href="<?php the_permalink(); ?>">
                                    <i class="fab <?php echo esc_html ($service_page->icons ); ?>"></i>
                                </a>
                            </div> 
                        <?php } ?>

                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                        <?php the_excerpt(); ?>

                    </div>
                <?php endwhile; endif; wp_reset_postdata();  endif;   endforeach; endif; ?>
            </div>

        </div>
    </section>
	<?php 

}
add_action('medical_heed_action_facility','medical_heed_facility',60);

/**
 * Section Frequently Asked Question.
*/
function medical_heed_faq(){
    $title    = get_theme_mod('medical_heed_faq_title');
    $subtitle = get_theme_mod('medical_heed_faq_subtitle');
    $faq      = get_theme_mod('medical_heed_faq');
    $appointment_title = get_theme_mod('medical_heed_appointment_title');
    $appointment_subtitle = get_theme_mod('medical_heed_appointment_subtitle');
    $shortcode = get_theme_mod('medical_heed_appointment_shortcode');
    ?>
    <section class="faq">
        <div class="container">
            <div class="row">
                <?php if (!empty ($appointment_title) || !empty($shortcode)): ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 booking_form no-right-padding">

                        <?php if (!empty ($appointment_title)): ?>

                            <h2><?php echo esc_html($appointment_title); ?></h2>

                        <?php endif; 

                         if (!empty ($appointment_subtitle)): ?>

                            <p><?php echo esc_html($appointment_subtitle); ?></p>

                        <?php endif;  if (!empty($shortcode)) :

                            echo do_shortcode($shortcode); 

                            endif; 
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php  if (!empty( $title ) || !empty( $subtitle ) ) { ?>

                    <div class="col-lg-6 col-md-6 col-sm-12 faq_accordance no-left-padding">
                        <?php  if (!empty( $title ) ) : ?>

                                <h2><?php echo esc_html( $title ); ?></h2>

                        <?php endif; if (!empty( $subtitle ) ) : ?>

                                <p><?php echo esc_html( $subtitle ); ?><p>

                        <?php endif; ?>

                        <div class="accordion js-accordion">
                            <?php 
                                if (!empty( $faq ) ) :
                                $questions  =   json_decode( $faq );
                                    foreach ( $questions as $question ) {
                                    $count = 1;
                                    if (!empty ($question->title ) ) { ?>
                                        <div class="accordion__item js-accordion-item <?php if($count == 1){ echo 'active';} ?>">
                                            <div class="accordion-header js-accordion-header "><?php echo esc_html ($question->title ); ?></div>
                                            <div class="accordion-body js-accordion-body">
                                                <div class="accordion-body__contents">
                                                    <?php echo esc_html ($question->subtitle ); ?>
                                                </div>
                                            </div>
                                        </div><!-- end of accordion body -->      
                            <?php } } endif; ?>
                        </div><!-- end of accordion item -->
                    </div><!-- end of accordion -->
                <?php } ?>
            </div>
        </div>
    </section>
    <?php }
add_action('medical_heed_action_faq','medical_heed_faq',75);

/**
 * Section Services.
*/
function medical_heed_services(){
    $title    = get_theme_mod('medical_heed_services_title');
    $subtitle = get_theme_mod('medical_heed_services_subtitle');
    ?>
    <section class="services">
        <div class="container">
            <?php 
                if (!empty( $title ) || !empty( $subtitle) ) : ?>
                    <div class="row">
                         <div class="col-lg-12 sectiontitle">
                            <?php if (!empty($title)) : ?>

                                    <h2><?php echo esc_html($title); ?></h2>

                            <?php endif; if (!empty( $subtitle ) ) : ?>

                                    <p><?php echo esc_html($subtitle); ?></p>

                            <?php endif; ?>
                         </div>
                    </div>
            <?php endif; ?>
            
            <div class="row">
                <?php 
                    $pages = array();
                    for ( $count = 1; $count <= 6; $count++ ) {
                        $services = get_theme_mod( 'medical_heed_services_img' . $count );

                        if ( 'page-none-selected' != $services ) {
                            $pages[] = $services;
                        }
                    }

                    $args = array(
                        'posts_per_page' => 6,
                        'post_type' => 'page',
                        'post__in' => $pages,
                        'orderby' => 'post__in'
                    );

                    $query = new WP_Query( $args );

                    if ( $query->have_posts() ) :
                        $count = 1;
                        while ( $query->have_posts() ) : $query->the_post();
                ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="box">
                            <figure>
                                <a href="<?php the_permalink();?>">
                                    <?php the_post_thumbnail('medical-head-about-image'); ?>
                                </a>
                            </figure>
                            <div class="description">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                <?php $count++; endwhile;  endif; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php
}
add_action('medical_heed_action_services','medical_heed_services',95);

/**
 * Call To Action Section
*/
function medical_heed_discounts(){

    $title   = get_theme_mod('medical_heed_discount');
    $btn     = get_theme_mod('medical_heed_discount_btn');
    $btn_url = get_theme_mod('medical_heed_discount_btn_url');
    $image = get_theme_mod('medical_heed_call_action_image');

    if (!empty( $title ) ) : ?>

        <section class="call_to_action" style="background: url( <?php echo esc_url( wp_get_attachment_url( $image ) ); ?>)">
            <div class="col-lg-12">

                <?php if (!empty($title)) : ?>
                        <h4>
                            <?php echo esc_html($title); ?>
                        </h4>

                 <?php endif; if (!empty($btn)) : ?>

                        <a href="<?php echo esc_url($btn_url); ?>"><?php echo esc_html($btn); ?></a>

                <?php endif; ?>
            </div>
        </section>

    <?php  endif; }

add_action('medical_heed_action_discount','medical_heed_discounts',110);

/**
 * Section Blog Posts.
*/
function medical_heed_blog_posts(){
    $title      = get_theme_mod('medical_heed_blog_title');
    $subtitle   = get_theme_mod('medical_heed_blog_subtitle');
    $blogcategory = get_theme_mod('medical_heed_blog_categories');
    $cat_id     = explode(',', $blogcategory);
    ?>
    <section class="services blog-list">
        <div class="container">
            <?php if (!empty( $title ) || !empty( $subtitle ) ) : ?>
                <div class="row">
                     <div class="col-lg-12 sectiontitle">
                        <?php if (!empty ($title)) : ?>

                                <h2><?php echo esc_html($title); ?></h2>

                        <?php endif; if (!empty ($subtitle)) : ?>

                                <p><?php echo esc_html($subtitle); ?></p>

                        <?php endif; ?>
                     </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <?php 
                    $args   = array (
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'tax_query'      => array (
                            array(
                                'taxonomy'  => 'category',
                                'field'     => 'term_id',
                                'terms'     => $cat_id
                            ),
                        ), 
                    ); 

                    $query = new WP_Query ( $args );

                    if ( $query->have_posts() ): while ( $query->have_posts() ) :  $query->the_post();
                ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="box">
                           
                            <figure>
                                <a href="<?php the_permalink();?>">
                                    <?php the_post_thumbnail('medical-head-about-image'); ?>
                                </a>
                            </figure>

                            <div class="description">
                               
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                
                                <?php if ( 'post' === get_post_type() ) : ?>
                                    <div class="entry-meta">
                                        <?php
                                            medical_heed_posted_by();
                                            medical_heed_posted_on();
                                            medical_heed_comments();
                                        ?>
                                    </div><!-- .entry-meta -->
                                <?php endif; ?>

                                <?php the_excerpt(); ?>

                                <div class="btns">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                        <span><?php esc_html_e('Read More','medical-heed'); ?></span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php  endwhile;  endif; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>

    <?php }
add_action('medical_heed_action_blog_posts','medical_heed_blog_posts',120);

/**
* Section Testimonials.
*/
function medical_heed_testimonials(){
    $title         = get_theme_mod('medical_heed_testimonial_title');
    $subtitle      = get_theme_mod('medical_heed_testimonial_subtitle');
    $testimonial_page   = get_theme_mod('medical_heed_testimonials');

    if (!empty( $testimonial_page ) ) {  ?>
        <section class="testimonial">
            <div class="container">
                <?php if (!empty( $title ) || !empty( $subtitle ) ) : ?>
                    <div class="row">
                         <div class="col-lg-12 sectiontitle">
                            <?php if (!empty ( $title )) : ?>

                                <h2><?php echo esc_html($title); ?></h2>

                            <?php endif; if (!empty ($subtitle)) : ?>

                                    <p><?php echo esc_html($subtitle); ?></p>

                            <?php endif; ?>
                         </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="owl-testimonial owl-carousel owl-theme">
                        <?php 
                            if( !empty( $testimonial_page ) ) :

                            $testimonials = json_decode( $testimonial_page );

                            foreach($testimonials as $testimonial): 
                               
                                $page_id = $testimonial->testimonial_page_id;
                                 
                            if( !empty( $page_id ) ) :

                                $testimonial_query = new WP_Query( 'page_id='.$page_id );       

                                if( $testimonial_query->have_posts() ) : 
                                 while( $testimonial_query->have_posts() ) :  $testimonial_query->the_post(); ?>
                                    <div class="item">
                                        <div class="testimonial-wrap">
                                            <div class="box">
                                                <div class="testimonial-image">
                                                    <figure>
                                                        <a href="<?php the_permalink(); ?>">
                                                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                                                        </a>
                                                    </figure>
                                                </div>

                                                <div class="testimonial-content">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                            </div>

                                            <h3>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            
                                        </div>
                                    </div><!-- item -->
                        <?php endwhile; endif; wp_reset_postdata();  endif; endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } }

add_action('medical_heed_Action_testimonials','medical_heed_testimonials',135);


