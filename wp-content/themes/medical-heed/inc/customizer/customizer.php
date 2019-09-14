<?php
/**
 * Medical Heed Theme Customizer
 *
 * @package Medical_Heed
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function medical_heed_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'medical_heed_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'medical_heed_customize_partial_blogdescription',
		) );
	}

/**
 * List All Pages
*/
$allpages = array();
$pages_obj = get_pages();
$allpages[''] = esc_html__('Select Page','medical-heed');
foreach ($pages_obj as $page) {
  $allpages[$page->ID] = $page->post_title;
}

	
/**
 * Option to get the frontpage settings to the old default template if a static frontpage is selected
*/
$wp_customize->get_section('static_front_page' )->priority = 2;

$wp_customize->add_section( 'medical_heed_enable_frontpage', array(
	'title'		=>	esc_html__('Enable Front Page','medical-heed'),
	'priority'	=>	2
));

	$wp_customize->add_setting( 'medical_heed_front_page', array(
		'sanitize_callback' => 'medical_heed_sanitize_checkbox',
		'default' => false
	));

	$wp_customize->add_control( 'medical_heed_front_page', array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Enable Medical Heed Style frontpage?','medical-heed' ),
		'section' => 'medical_heed_enable_frontpage'
	));

/**
 * Add General Settings Panel
 *
 * @since 1.0.0
*/
$wp_customize->add_panel(
    'medical_heed_general_settings_panel',
    array(
        'priority'       => 2,
        'title'          => esc_html__( 'General Settings', 'medical-heed' ),
    )
);

	$wp_customize->get_section( 'title_tagline' )->panel = 'medical_heed_general_settings_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = 5;

    $wp_customize->get_section( 'colors' )->panel = 'medical_heed_general_settings_panel';
    $wp_customize->get_section('colors' )->title = esc_html__('Colors Settings', 'medical-heed');
    $wp_customize->get_section( 'colors' )->priority = 6;

    $wp_customize->get_section( 'header_image' )->panel = 'medical_heed_general_settings_panel';
    $wp_customize->get_section('header_image' )->title = esc_html__('Header Background Image', 'medical-heed');
    $wp_customize->get_section( 'header_image' )->priority = 8;

    $wp_customize->get_section( 'background_image' )->panel = 'medical_heed_general_settings_panel';
    $wp_customize->get_section( 'background_image' )->priority = 15;

    $wp_customize->get_section( 'static_front_page' )->panel = 'medical_heed_general_settings_panel';
    $wp_customize->get_section( 'static_front_page' )->priority = 20;

	    
/**
 *  Theme Options Panel.
 */
$wp_customize->add_panel('medical_heed_theme_options', array(
	'title'		=>	esc_html__('Theme Options','medical-heed'),
	'priority'	=>	30,
));

	/**
	 *  Header Social Icons.
	 */

	$wp_customize->add_section( 'medical_heed_header', array(
		'title'		=>	esc_html__('Top Header Settings','medical-heed'),
		'panel'		=>	'medical_heed_theme_options',
		'priority'	=>	10
	));

	// Enable or Disable Top Bar.
	$wp_customize->add_setting( 'medical_heed_topbar', array(
		'default'			=> 'enable',
		'sanitize_callback' => 'medical_heed_sanitize_switch', 	 //done	
	));

	$wp_customize->add_control( new medical_heed_switch_control($wp_customize, 'medical_heed_topbar', array(
		'label'			=> esc_html__( 'Enable Top Bar', 'medical-heed' ),
		'settings'		=> 'medical_heed_topbar',
		'section'		=> 'medical_heed_header',
		'switch_label' 	=> array(
			'enable'  => esc_html__( 'Enable', 'medical-heed' ),
			'disable' => esc_html__( 'Disable', 'medical-heed' ),
		),
	)));

	// Map Location.
	$wp_customize->add_setting( 'medical_heed_location', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_location', array(
		'label'				=> esc_html__( 'Enter Office Location', 'medical-heed' ),
		'settings'			=> 'medical_heed_location',
		'section'			=> 'medical_heed_header',
		'type'		  		=> 'text',
	)));

	// Opening Time.
	$wp_customize->add_setting( 'medical_heed_time', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_time', array(
		'label'			  => esc_html__( 'Opening Time', 'medical-heed' ),
		'settings'		  => 'medical_heed_time',
		'section'		  => 'medical_heed_header',
		'type'		  	  => 'text',
	)));

	// Contact number.
	$wp_customize->add_setting( 'medical_heed_contact', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_contact', array(
		'label'			  => esc_html__( 'Enter Contact Number', 'medical-heed' ),
		'settings'		  => 'medical_heed_contact',
		'section'		  => 'medical_heed_header',
		'type'		  	  => 'text',
	)));

	// Contact Email .
	$wp_customize->add_setting( 'medical_heed_email', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_email', array(
		'label'			  => esc_html__( 'Enter Email Address', 'medical-heed' ),
		'settings'		  => 'medical_heed_email',
		'section'		  => 'medical_heed_header',
		'type'		  	  => 'text',
	)));

	// Enable or Disable Social Media Icon.
	$wp_customize->add_setting( 'medical_heed_social', array(
		'default'			=> 'enable',
		'sanitize_callback' => 'medical_heed_sanitize_switch', 	 //done	
	));

	$wp_customize->add_control(new medical_heed_switch_control($wp_customize, 'medical_heed_social', array(
		'label'			  => esc_html__('Enable Social Links','medical-heed'),
		'settings'		  => 'medical_heed_social',
		'section'		  => 'medical_heed_header',
		'switch_label' 	  => array(
			'enable'  => esc_html__( 'Enable', 'medical-heed' ),
			'disable' => esc_html__( 'Disable', 'medical-heed' ),
		),
	)));

	// Facebook Icons.
	$wp_customize->add_setting( 'medical_heed_facebook', array(
		'sanitize_callback' => 'esc_url_raw', 	 //done	
	));

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'medical_heed_facebook', array(
		'label'			  => esc_html__('Facebook URL','medical-heed'),
		'settings'		  => 'medical_heed_facebook',
		'section'		  => 'medical_heed_header',
		'active_callback' => 'medical_heed_social_active',
		'type'			  => 'url',
	)));

	// Twitter.
	$wp_customize->add_setting( 'medical_heed_twitter', array(
		'sanitize_callback' => 'esc_url_raw', 	 //done	
	));

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'medical_heed_twitter', array(
		'label'			  => esc_html__('Twitter URL','medical-heed'),
		'settings'		  => 'medical_heed_twitter',
		'section'		  => 'medical_heed_header',
		'active_callback' => 'medical_heed_social_active',
		'type'			  => 'url',
	)));

	// Instagram.
	$wp_customize->add_setting( 'medical_heed_instagram', array(
		'sanitize_callback' => 'esc_url_raw', 	 //done	
	));

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'medical_heed_instagram', array(
		'label'			  => esc_html__('Instagram URL','medical-heed'),
		'settings'		  => 'medical_heed_instagram',
		'section'		  => 'medical_heed_header',
		'active_callback' => 'medical_heed_social_active',
		'type'			  => 'url',
	)));

	// Youtube.
	$wp_customize->add_setting( 'medical_heed_youtube', array(
		'sanitize_callback' => 'esc_url_raw', 	 //done	
	));

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'medical_heed_youtube', array(
		'label'			  => esc_html__('Youtube URL','medical-heed'),
		'settings'		  => 'medical_heed_youtube',
		'section'		  => 'medical_heed_header',
		'active_callback' => 'medical_heed_social_active',
		'type'			  => 'url',
	)));

	/**
	 * Page, Post Category Sidebar.
	*/
	$wp_customize->add_section( 'medical_heed_sidebar_section', array(
		'title'		=>	esc_html__('Sidebar Settings','medical-heed'),
		'panel'		=>	'medical_heed_theme_options',
	));

	// Select Sidebar Options.
	$wp_customize->add_setting('medical_heed_sidebar_options',array(
		'default'			 =>	'right',
		'sanitize_callback'	 =>	'medical_heed_sanitize_select'		//done	
	));

	$wp_customize->add_control( new WP_Customize_Control ($wp_customize,'medical_heed_sidebar_options', array(
		'label'	  =>	esc_html__('Post, Page & Category Siderbar Options','medical-heed'),
		'section' =>	'medical_heed_sidebar_section',
		'setting' =>	'medical_heed_sidebar_options',
		'type'	  =>	'select',
		'choices' => array(
			'no'    => esc_html__('No Sidebar','medical-heed'),
			'right' => esc_html__( 'Right Sidebar','medical-heed' ),
	   		'left' 	=> esc_html__( 'Left Sidebar','medical-heed' ),
		)
	)));

	/**
	 * Footer Content.
	 */
    $wp_customize->add_section('medical_heed_footer',array(
    	'title'		=>	esc_html__('Copyright Information','medical-heed'),
    	'panel'		=>	'medical_heed_theme_options',
    ));

     $wp_customize->add_setting('medical_heed_footer_content',array(
	    'sanitize_callback' => 'sanitize_text_field',      //done  
    ));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'medical_heed_footer_content',array(
        'label'      => esc_html__( 'Enter Copyright Text', 'medical-heed' ),
        'section'    => 'medical_heed_footer',
        'settings'   => 'medical_heed_footer_content',
        'type'		=>	'text'
    )));


	/**
	 *	Mani Banner Slider
	*/
	$wp_customize->add_section('medical_heed_featured_slider', array(
        'title'          => esc_html__( 'Slider Settings', 'medical-heed' ),
        'priority'       => 35,
        'description'=> esc_html__('[ Note : Slider Area Display Selected Page (Title, Description & Features Image). ]','medical-heed'),
    ));

	// Slider Page Options.
	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'medical_heed_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'absint'
		) );

		$wp_customize->add_control( 'medical_heed_slider' . $count, array(
			'label'    => esc_html__( 'Select Slider Page', 'medical-heed' ),
			'section'  => 'medical_heed_featured_slider',
			'type'     => 'dropdown-pages'
		));

	}// end loop.

	/**
	 * HomePage Settings.
	*/
	$wp_customize->add_panel('medical_heed_homepage', array(
		'title'		=>	esc_html__('Homepage Settings','medical-heed'),
		'priority'	=>	40,
	));


	/**
	 * Features Services Section
	*/
	$wp_customize->add_section( 'medical_heed_features_services_area', array(
		'title'		=> esc_html__('Features Services Section','medical-heed'),
		'panel'		=> 'medical_heed_homepage',
	));


		//  Features Services Area
	    $wp_customize->add_setting( 'medical_heed_features_services_options', array(
	    	'sanitize_callback'	=> 'medical_heed_sanitize_repeater',		//done
			'default' 			=> json_encode( array(
	            array(
	                  'icons' => 'fa fa-ambulance',
	                  'service_page'=>'', 
	                )
	            ) 
		)));

		$wp_customize->add_control ( new medical_heed_Repeater ( $wp_customize,'medical_heed_features_services_options',
			array(
				'label'						   =>	esc_html__('Features Services Setting','medical-heed'),
				'section'					   =>	'medical_heed_features_services_area',
				'setting'					   =>	'medical_heed_features_services_options',
				'medical_heed_box_label' 	   =>	 esc_html__('Features Services Options','medical-heed'),
				'medical_heed_box_add_control' => esc_html__('Add New Services','medical-heed'),
			),
		array(
			'icons'   => array(
				'type'      => 'icon',
				'default'   => 'fa fa-ambulance',
				'label'     => esc_html__( 'Select Icon', 'medical-heed' ),
			),
			'service_page'  => array(
				'type'  =>'select',
				'label' => esc_html__( 'Select Featured Page', 'medical-heed'),
				'options'   => $allpages,
				'default'   => ''
			),
		)));

	/**
	 * Popular For.
	*/
	$wp_customize->add_section( 'medical_heed_popular_for', array(
		'title'		=> esc_html__('Promo Services Section','medical-heed'),
		'panel'		=> 'medical_heed_homepage',
	));

	// Popular For title.
	$wp_customize->add_setting( 'medical_heed_popular_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_popular_title', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_popular_title',
		'section'	=> 'medical_heed_popular_for',
		'type'		=> 'text'
	)));

	// Popular For description.
	$wp_customize->add_setting( 'medical_heed_popular_description', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_popular_description', array(
		'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
		'settings'	=> 'medical_heed_popular_description',
		'section'	=> 'medical_heed_popular_for',
		'type'		=> 'text'
	)));

	// Popular For image.
	for ( $count = 1; $count <= 5; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'medical_heed_popular_img' . intval( $count ), array(
			'default'           => '',
			'sanitize_callback' => 'absint'
		) );

		$wp_customize->add_control( 'medical_heed_popular_img' . intval( $count ) , array(
			'label'    => sprintf( esc_html_x( 'Select Page #%s', 'post author', 'medical-heed' ),
			intval( $count ) ),
			'section'  => 'medical_heed_popular_for',
			'type'     => 'dropdown-pages',
		));

	}// end loop.


	/**
	 * About Us
	*/
	$wp_customize->add_section( 'medical_heed_treatment_section', array(
		'title'		=>	esc_html__('About Us Section','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// Treatment image.
	$wp_customize->add_setting( 'medical_heed_treatment_image', array(
		'sanitize_callback' => 'absint',      //done
	));

	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'medical_heed_treatment_image', array(
		'label' => esc_html__('Cropped the selected Image', 'medical-heed'),
		'section' => 'medical_heed_treatment_section',
		'height' => 460,
		'width' => 550,
	)));

	// Treatment .
	$wp_customize->add_setting( 'medical_heed_treatment', array(
		'sanitize_callback' => 'absint', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_treatment', array(
		'label'		=> esc_html__( 'Select About Us Page', 'medical-heed' ),
		'settings'	=> 'medical_heed_treatment',
		'section'	=> 'medical_heed_treatment_section',
		'type'		=> 'dropdown-pages',
	)));


	/**
	 * Facilities.
	*/
	$wp_customize->add_section( 'medical_heed_facility', array(
		'title'		=>	esc_html__('Our Services Section','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// Facilities title.
	$wp_customize->add_setting( 'medical_heed_facility_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_facility_title', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_facility_title',
		'section'	=> 'medical_heed_facility',
		'type'		=> 'text'
	)));

	// Facilities Subtitle.
	$wp_customize->add_setting( 'medical_heed_facility_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_facility_subtitle', array(
		'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
		'settings'	=> 'medical_heed_facility_subtitle',
		'section'	=> 'medical_heed_facility',
		'type'		=> 'text'
	)));

	//  Facilities Icons.
    $wp_customize->add_setting( 'medical_heed_facility_icons', array(
    	'sanitize_callback'	=> 'medical_heed_sanitize_repeater',		//done
		'default' 			=> json_encode( array(
            array(
                  'icons' => 'fa fa-ambulance',
                  'service_page'=>'', 
                )
            ) 
	)));

	$wp_customize->add_control ( new medical_heed_Repeater ( $wp_customize,'medical_heed_facility_icons',
		array(
			'label'						   =>	esc_html__('Services Setting','medical-heed'),
			'section'					   =>	'medical_heed_facility',
			'setting'					   =>	'medical_heed_facility_icons',
			'medical_heed_box_label' 	   =>	 esc_html__('Services Settings Options','medical-heed'),
			'medical_heed_box_add_control' => esc_html__('Add New Services','medical-heed'),
		),
	array(
		'icons'   => array(
			'type'      => 'icon',
			'default'   => 'fa fa-ambulance',
			'label'     => esc_html__( 'Select Icon', 'medical-heed' ),
		),
		'service_page'  => array(
			'type'  =>'select',
			'label' => esc_html__( 'Select Featured Page', 'medical-heed'),
			'options'   => $allpages,
			'default'   => ''
		),
	)));

	/**
	 * Make An Appointment.
	*/
	$wp_customize->add_section( 'medical_heed_appointment', array(
		'title'		=>	esc_html__('Quick Contact Form Area','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// Appointment title.
	$wp_customize->add_setting( 'medical_heed_appointment_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_appointment_title', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_appointment_title',
		'section'	=> 'medical_heed_appointment',
		'type'		=> 'text'
	)));

	// Appointment Subtitle.
	$wp_customize->add_setting( 'medical_heed_appointment_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_appointment_subtitle', array(
		'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
		'settings'	=> 'medical_heed_appointment_subtitle',
		'section'	=> 'medical_heed_appointment',
		'type'		=> 'text'
	)));

	// Appointment Shortcode for Form.
	$wp_customize->add_setting( 'medical_heed_appointment_shortcode', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_appointment_shortcode', array(
		'label'		=> esc_html__( 'Enter Contact Form7 Plugins Shortcode', 'medical-heed' ),
		'settings'	=> 'medical_heed_appointment_shortcode',
		'section'	=> 'medical_heed_appointment',
		'type'		=> 'text',
		'description' => esc_html__('Note: First you can install Contact Form 7 plugins and create your form per as you want and enter generated shortcode exmaple : [contact-form-7 id="111" title="Contact form 1"]','medical-heed')
	)));

	/**
	 * FAQ.
	*/
	$wp_customize->add_section( 'medical_heed_faq_section', array(
		'title'		=>	esc_html__('Frequently Asked Questions','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// FAQ title.
	$wp_customize->add_setting( 'medical_heed_faq_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_faq_title', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_faq_title',
		'section'	=> 'medical_heed_faq_section',
		'type'		=> 'text'
	)));

	// FAQ Subtitle.
	$wp_customize->add_setting( 'medical_heed_faq_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_faq_subtitle', array(
		'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
		'settings'	=> 'medical_heed_faq_subtitle',
		'section'	=> 'medical_heed_faq_section',
		'type'		=> 'text'
	)));

	//  FAQ.
    $wp_customize->add_setting( 'medical_heed_faq', array(
    	'sanitize_callback'	=> 'medical_heed_sanitize_repeater',		//done
		'default' 			=> json_encode( array(
            array(
                  'title'       => '',
                  'subtitle'    => '', 
                )
            ) 
	)));

	$wp_customize->add_control(new medical_heed_Repeater($wp_customize,'medical_heed_faq',array(
	'label'						   => esc_html__('FAQ Settings','medical-heed'),
	'section'					   => 'medical_heed_faq_section',
	'setting'					   => 'medical_heed_faq',
	'medical_heed_box_label' 	   => esc_html__('FAQ Options','medical-heed'),
	'medical_heed_box_add_control' => esc_html__('Add New FAQ','medical-heed'),
	),
	array(
		'title'  => array(
			'type'  =>'text',
			'label' => esc_html__( 'Title', 'medical-heed'),
		),
		'subtitle'  => array(
			'type'  =>'text',
			'label' => esc_html__( 'Subtitle', 'medical-heed'),
		)
	)));

	/**
	*	Our Services.
	*/
	$wp_customize->add_section( 'medical_heed_services', array(
		'title'		=>	esc_html__('Services area with Features Image ','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// Services title.
	$wp_customize->add_setting( 'medical_heed_services_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_services_title', array(
			'label'		=> esc_html__( 'Title', 'medical-heed' ),
			'settings'	=> 'medical_heed_services_title',
			'section'	=> 'medical_heed_services',
			'panel'		=> 'medical_heed_homepage',
			'type'		=> 'text'
	)));

	// Services subtitle.
	$wp_customize->add_setting( 'medical_heed_services_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_services_subtitle', array(
			'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
			'settings'	=> 'medical_heed_services_subtitle',
			'section'	=> 'medical_heed_services',
			'panel'		=> 'medical_heed_homepage',
			'type'		=> 'text'
	)));

	// Services image.
	for ( $count = 1; $count <= 6; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'medical_heed_services_img' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'absint'
		) );

		$wp_customize->add_control( 'medical_heed_services_img' . $count, array(
			'label'    => sprintf( esc_html_x( 'Select Page #%s', 'post author', 'medical-heed' ),
			intval( $count ) ),
			'section'  => 'medical_heed_services',
			'type'     => 'dropdown-pages',
		));

	}// end loop.

	/**
	 * Call To Action.
	*/
	$wp_customize->add_section( 'medical_heed_discount_section', array(
		'title'		=>	esc_html__('Call To Action Section','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));
	// Call To Action image.
	$wp_customize->add_setting( 'medical_heed_call_action_image', array(
		'sanitize_callback' => 'absint',      //done
	));

	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'medical_heed_call_action_image', array(
		'label' => esc_html__('Cropped the selected Image', 'medical-heed'),
		'section' => 'medical_heed_discount_section',
		'width' => 1300,
		'height' => 400,
	)));

	// Call To Action title.
	$wp_customize->add_setting( 'medical_heed_discount', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_discount', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_discount',
		'section'	=> 'medical_heed_discount_section',
		'type'		=> 'text'
	)));

	// Call To Action Button Text.
	$wp_customize->add_setting( 'medical_heed_discount_btn', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_discount_btn', array(
		'label'		=> esc_html__( 'Button Text', 'medical-heed' ),
		'settings'	=> 'medical_heed_discount_btn',
		'section'	=> 'medical_heed_discount_section',
		'type'		=> 'text'
	)));

	// Call To Action Button Url.
	$wp_customize->add_setting( 'medical_heed_discount_btn_url', array(
		'sanitize_callback' => 'esc_url_raw', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_discount_btn_url', array(
		'label'		=> esc_html__( 'Button URL', 'medical-heed' ),
		'settings'	=> 'medical_heed_discount_btn_url',
		'section'	=> 'medical_heed_discount_section',
		'type'		=> 'url'
	)));

	/**
	 * Blog Posts.
	*/
	$wp_customize->add_section( 'medical_heed_blog_posts', array(
		'title'		=>	esc_html__('Blog Posts Section','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// Blog Posts title.
	$wp_customize->add_setting( 'medical_heed_blog_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_blog_title', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_blog_title',
		'section'	=> 'medical_heed_blog_posts',
		'type'		=> 'text'
	)));

	// Blog Posts subtitle.
	$wp_customize->add_setting( 'medical_heed_blog_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_blog_subtitle', array(
		'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
		'settings'	=> 'medical_heed_blog_subtitle',
		'section'	=> 'medical_heed_blog_posts',
		'type'		=> 'text'
	)));


	// List All Category
			$categories = get_categories();
			$blog_cat  = array();

			foreach( $categories as $category ) {
			    $blog_cat[$category->term_id] = $category->name;
			}

	$wp_customize->add_setting( 'medical_heed_blog_categories', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new medical_heed_multiple_check_control($wp_customize, 'medical_heed_blog_categories', array(
		'label'		=> esc_html__( 'Select Category', 'medical-heed' ),
		'settings'	=> 'medical_heed_blog_categories',
		'section'	=> 'medical_heed_blog_posts',
		'choices'		=> $blog_cat
	)));

	/**
	 * Testimonials.
	*/
	$wp_customize->add_section( 'medical_heed_testimonials_section', array(
		'title'		=>	esc_html__('Testimonials Section','medical-heed'),
		'panel'		=>	'medical_heed_homepage',
	));

	// Testimonials title.
	$wp_customize->add_setting( 'medical_heed_testimonial_title', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_testimonial_title', array(
		'label'		=> esc_html__( 'Title', 'medical-heed' ),
		'settings'	=> 'medical_heed_testimonial_title',
		'section'	=> 'medical_heed_testimonials_section',
		'type'		=> 'text'
	)));

	// Testimonials subtitle.
	$wp_customize->add_setting( 'medical_heed_testimonial_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'medical_heed_testimonial_subtitle', array(
		'label'		=> esc_html__( 'Subtitle', 'medical-heed' ),
		'settings'	=> 'medical_heed_testimonial_subtitle',
		'section'	=> 'medical_heed_testimonials_section',
		'type'		=> 'text'
	)));

	//Testimonials
    $wp_customize->add_setting( 'medical_heed_testimonials', array(
      'sanitize_callback' => 'medical_heed_sanitize_repeater',
      'default' => json_encode( array(
        array(
              'testimonial_page_id' => '' 
            )
        ) )        
    ));

    $wp_customize->add_control( new medical_heed_Repeater( $wp_customize, 'medical_heed_testimonials', array(
      'label'    => esc_html__('Testimonials Settings','medical-heed'),
      'section'  => 'medical_heed_testimonials_section',
      'settings' => 'medical_heed_testimonials',
      'medical_heed_box_label' => esc_html__('Testimonials Settings','medical-heed'),
      'medical_heed_box_add_control' => esc_html__('Add New Testimonials','medical-heed'),
    ),
    array(
		'testimonial_page_id' => array(
			'type'      => 'select',
			'label'     => esc_html__( 'Select Testimonial Page', 'medical-heed' ),
			'options'   => $allpages
		)          
    )));
        
}
add_action( 'customize_register', 'medical_heed_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function medical_heed_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function medical_heed_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 *
 */
function medical_heed_customize_scripts() {

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/font-awesome/css/fontawesome.min.css', array(), '5.0.0' );
    
    wp_enqueue_style( 'medical-heed-customizer', get_template_directory_uri() . '/assets/css/customizer.css' );

    wp_enqueue_script( 'medical-heed-customizer', get_template_directory_uri() . '/assets/js/medical-heed.js', array( 'jquery', 'customize-controls' ), '20180910', true );
	
}
add_action( 'customize_controls_enqueue_scripts', 'medical_heed_customize_scripts' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function medical_heed_customize_preview_js() {
	wp_enqueue_script( 'medical-heed-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'medical_heed_customize_preview_js' );
