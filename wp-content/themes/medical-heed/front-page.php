<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Medical_Heed
 */

get_header(); 

    /**
     * Enable Front Page
    */
    do_action( 'medical_heed_enable_front_page' );

    $enable_front_page = get_theme_mod( 'medical_heed_front_page' ,false);

    if( $enable_front_page == 1 ) {

        /**
         * Hook -  medical_heed_action_slider 
         *
         * @hooked medical_heed_featured_slider - 20
        */
        do_action('medical_heed_action_slider');

        /**
         * Hook -  medical_heed_features_services 
         *
         * @hooked medical_heed_features_services_area - 25
        */
        do_action('medical_heed_features_services');

        /**
         * Hook -  medical_heed_action_popular 
         *
         * @hooked medical_heed_popular_for - 30
        */
        do_action('medical_heed_action_popular');

        /**
         * Hook -  medical_heed_action_treatment 
         *
         * @hooked medical_heed_treatment - 45
        */
        do_action('medical_heed_action_treatment');

        /**
         * Hook -  medical_heed_action_facility 
         *
         * @hooked medical_heed_facility - 60
        */
        do_action('medical_heed_action_facility');

        /**
         * Hook -  medical_heed_action_faq 
         *
         * @hooked medical_heed_faq - 75
        */
        do_action('medical_heed_action_faq');

        /**
         * Hook -  medical_heed_action_services 
         *
         * @hooked medical_heed_services - 95
        */
        do_action('medical_heed_action_services');
        
        /**
         * Hook -  medical_heed_action_discount 
         *
         * @hooked medical_heed_discounts - 110
        */
        do_action('medical_heed_action_discount');

        /**
         * Hook -  medical_heed_action_blog_posts 
         *
         * @hooked medical_heed_blog_posts - 120
        */
        do_action('medical_heed_action_blog_posts');

        /**
         * Hook -  medical_heed_Action_testimonials 
         *
         * @hooked medical_heed_testimonials - 135
        */
        do_action('medical_heed_Action_testimonials');

    } 

get_footer();