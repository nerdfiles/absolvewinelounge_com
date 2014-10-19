<?php
/**
 * absolve-wine-lounge functions file
 *
 * @package WordPress
 * @subpackage absolve-wine-lounge
 * @since absolve-wine-lounge 1.0
 */


/******************************************************************************\
	Theme support, standard settings, menus and widgets
\******************************************************************************/

add_theme_support( 'post-formats', array( 'image', 'quote', 'status', 'link' ) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );

$custom_header_args = array(
	'width'         => 980,
	'height'        => 300,
	'default-image' => get_template_directory_uri() . '/images/header.png',
);
add_theme_support( 'custom-header', $custom_header_args );

/**
 * Print custom header styles
 * @return void
 */
function absolvewinelounge_custom_header() {
	$styles = '';
	if ( $color = get_header_textcolor() ) {
		echo '<style type="text/css"> ' .
				'.site-header .logo .blog-name, .site-header .logo .blog-description {' .
					'color: #' . $color . ';' .
				'}' .
			 '</style>';
	}
}
add_action( 'wp_head', 'absolvewinelounge_custom_header', 11 );

$custom_bg_args = array(
	'default-color' => 'fba919',
	'default-image' => '',
);
add_theme_support( 'custom-background', $custom_bg_args );

register_nav_menu( 'main-menu', __( 'Your sites main menu', 'absolvewinelounge' ) );

if ( function_exists( 'register_sidebars' ) ) {
	register_sidebar(
		array(
			'id' => 'home-sidebar',
			'name' => __( 'Home widgets', 'absolvewinelounge' ),
			'description' => __( 'Shows on home page', 'absolvewinelounge' )
		)
	);

	register_sidebar(
		array(
			'id' => 'footer-sidebar',
			'name' => __( 'Footer widgets', 'absolvewinelounge' ),
			'description' => __( 'Shows in the sites footer', 'absolvewinelounge' )
		)
	);
}

if ( ! isset( $content_width ) ) $content_width = 650;

/**
 * Include editor stylesheets
 * @return void
 */
function absolvewinelounge_editor_style() {
    add_editor_style( 'css/wp-editor-style.css' );
}
add_action( 'init', 'absolvewinelounge_editor_style' );


/******************************************************************************\
	Scripts and Styles
\******************************************************************************/

/**
 * Enqueue absolvewinelounge scripts
 * @return void
 */
function absolvewinelounge_enqueue_scripts() {
	wp_enqueue_style( 'absolvewinelounge-styles', get_stylesheet_uri(), array(), '1.0' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'default-scripts', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0', true );
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'absolvewinelounge_enqueue_scripts' );


/******************************************************************************\
	Content functions
\******************************************************************************/

/**
 * Displays meta information for a post
 * @return void
 */
function absolvewinelounge_post_meta() {
	if ( get_post_type() == 'post' ) {
		echo sprintf(
			__( 'Posted %s in %s%s by %s. ', 'absolvewinelounge' ),
			get_the_time( get_option( 'date_format' ) ),
			get_the_category_list( ', ' ),
			get_the_tag_list( __( ', <b>Tags</b>: ', 'absolvewinelounge' ), ', ' ),
			get_the_author_link()
		);
	}
	edit_post_link( __( ' (edit)', 'absolvewinelounge' ), '<span class="edit-link">', '</span>' );
}