<?php
/**
 * hexagon: Customizer
 *
 * @subpackage hexagon
 * @since 1.0
 */

function hexagon_customize_register( $wp_customize ) {

	$wp_customize->add_setting('hexagon_show_site_title',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('hexagon_show_site_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Title','hexagon'),
       'section' => 'title_tagline'
    ));

    $wp_customize->add_setting('hexagon_show_tagline',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('hexagon_show_tagline',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Tagline','hexagon'),
       'section' => 'title_tagline'
    ));

	$wp_customize->add_panel( 'hexagon_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'hexagon' ),
	    'description' => __( 'Description of what this panel does.', 'hexagon' ),
	) );

	$wp_customize->add_section( 'hexagon_theme_options_section', array(
    	'title'      => __( 'General Settings', 'hexagon' ),
		'priority'   => 30,
		'panel' => 'hexagon_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('hexagon_theme_options',array(
        'default' => __('Right Sidebar','hexagon'),
        'sanitize_callback' => 'hexagon_sanitize_choices'	        
	));

	$wp_customize->add_control('hexagon_theme_options',array(
        'type' => 'radio',
        'label' => __('Do you want this section','hexagon'),
        'section' => 'hexagon_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','hexagon'),
            'Right Sidebar' => __('Right Sidebar','hexagon'),
            'One Column' => __('One Column','hexagon'),
            'Three Columns' => __('Three Columns','hexagon'),
            'Four Columns' => __('Four Columns','hexagon'),
            'Grid Layout' => __('Grid Layout','hexagon')
        ),
	));

	//home page slider
	$wp_customize->add_section( 'hexagon_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'hexagon' ),
		'priority'   => null,
		'panel' => 'hexagon_panel_id'
	) );

	$wp_customize->add_setting('hexagon_slider_hide_show',array(
       	'default' => 'true',
       	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('hexagon_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide slider','hexagon'),
	   	'description' => __('Image Size ( 375px x 375px )','hexagon'),
	   	'section' => 'hexagon_slider_section',
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

    $wp_customize->add_setting('hexagon_slider_cat',array(
	    'default' => 'select',
	    'sanitize_callback' => 'hexagon_sanitize_choices',
  	));
  	$wp_customize->add_control('hexagon_slider_cat',array(
	    'type'    => 'select',
	    'choices' => $cat_post,
	    'label' => __('Select Category to display Latest Post','hexagon'),
	    'description'	=> __('Size of image should be 570 x 380','hexagon'),
	    'section' => 'hexagon_slider_section',
	));

	// Our Services 
	$wp_customize->add_section('hexagon_services_section',array(
		'title'	=> __('Our Services','hexagon'),
		'description'=> __('This section will appear below the services.','hexagon'),
		'panel' => 'hexagon_panel_id',
	));
	
	$wp_customize->add_setting('hexagon_section_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('hexagon_section_title',array(
		'label'	=> __('Section Title','hexagon'),
		'section'	=> 'hexagon_services_section',
		'setting'	=> 'hexagon_section_title',
		'type'		=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('hexagon_services_cat',array(
		'default'	=> 'select',
		'sanitize_callback' => 'hexagon_sanitize_select',
	));
	$wp_customize->add_control('hexagon_services_cat',array(
		'type'    => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category to display Post','hexagon'),
		'section' => 'hexagon_services_section',
	));

	//Footer
    $wp_customize->add_section( 'hexagon_footer', array(
    	'title'      => __( 'Footer Text', 'hexagon' ),
		'priority'   => null,
		'panel' => 'hexagon_panel_id'
	) );

    $wp_customize->add_setting('hexagon_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('hexagon_footer_copy',array(
		'label'	=> __('Footer Text','hexagon'),
		'section'	=> 'hexagon_footer',
		'setting'	=> 'hexagon_footer_copy',
		'type'		=> 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'hexagon_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'hexagon_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'hexagon_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'hexagon_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'hexagon' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'hexagon' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'hexagon_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'hexagon_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'hexagon_customize_register' );

function hexagon_customize_partial_blogname() {
	bloginfo( 'name' );
}

function hexagon_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function hexagon_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function hexagon_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Hexagon_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Hexagon_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Hexagon_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__( 'Hexagon Pro ', 'hexagon' ),
					'pro_text' => esc_html__( 'Go Pro','hexagon' ),
					'pro_url'  => esc_url( 'https://www.luzuk.com/products/hexagon-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'hexagon-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'hexagon-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Hexagon_Customize::get_instance();