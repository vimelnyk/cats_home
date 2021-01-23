<?php
/**
 * Custom header implementation
 */

function hexagon_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'hexagon_custom_header_args', array(

		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1280,
		'height'                 => 75,
		'wp-head-callback'       => 'hexagon_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'hexagon_custom_header_setup' );

if ( ! function_exists( 'hexagon_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see hexagon_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'hexagon_header_style' );
function hexagon_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .top-header {
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'hexagon-basic-style', $custom_css );
	endif;
}
endif; // hexagon_header_style