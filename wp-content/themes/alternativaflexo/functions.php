<?php

function bootstrap_enqueue_styles() {
    wp_register_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
    $dependencies = array('bootstrap');
    wp_enqueue_style( 'bootstrap-style', get_stylesheet_uri(), $dependencies ); 
}
add_action( 'wp_enqueue_scripts', 'bootstrap_enqueue_styles' );

function fontawesome_enqueue_styles() {
    wp_register_style('fontawesome', get_template_directory_uri() . '/bootstrap/css/font-awesome.css' );
    $dependencies = array('fontawesome');
    wp_enqueue_style( 'fontawesome-style', get_stylesheet_uri(), $dependencies ); 
}
add_action( 'wp_enqueue_scripts', 'fontawesome_enqueue_styles' );

function animate_enqueue_styles() {
    wp_register_style('animate', get_template_directory_uri() . '/bootstrap/css/animate.css' );
    $dependencies = array('fontawesome');
    wp_enqueue_style( 'fontawesome-style', get_stylesheet_uri(), $dependencies ); 
}
add_action( 'wp_enqueue_scripts', 'animate_enqueue_styles' );

function cubeportifolio_animate_enqueue_styles() {
    wp_register_style('cubeportifolio', get_template_directory_uri() . '/bootstrap/css/cubeportifolio.min.css' );
    $dependencies = array('fontawesome');
    wp_enqueue_style( 'fontawesome-style', get_stylesheet_uri(), $dependencies ); 
}
add_action( 'wp_enqueue_scripts', 'cubeportifolio_animate_enqueue_styles' );

function wpb_add_google_fonts() {
	wp_enqueue_style( 'wpb-google-fonts', 'http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900|Open+Sans:300,400,600,700', false ); 
}
add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

function bootstrap_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/bootstrap/js/bootstrap.min.js', $dependencies, '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'bootstrap_enqueue_scripts' );

function stellar_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('stellar', get_template_directory_uri().'/bootstrap/js/stellar.js', $dependencies, '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'stellar_enqueue_scripts' );

function custom_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('custom', get_template_directory_uri().'/bootstrap/js/custom.js', $dependencies, '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );

function animate_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('animate', get_template_directory_uri().'/bootstrap/js/animate.js', $dependencies, '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'animate_enqueue_scripts' );

function jquery_appear_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('jquery_appear', get_template_directory_uri().'/bootstrap/js/jquery.appear.js', $dependencies, '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'jquery_appear_enqueue_scripts' );

function jquery_cubeportfolio_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('jquery_cubeportfolio', get_template_directory_uri().'/bootstrap/js/jquery.cubeportfolio.min.js', $dependencies, '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'jquery_cubeportfolio_enqueue_scripts' );

function bootstrap_wp_setup() {
    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'bootstrap_wp_setup' );

?>
