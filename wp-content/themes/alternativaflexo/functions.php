<?php

// CARREGA CSS, JS e FONTS

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

// FIM CARREGA CSS, JS e FONTS

// MENUS
add_action( 'after_setup_theme', 'registra_menus' );
    if ( ! function_exists( 'registra_menus' ) ):
        function registra_menus() {  
            register_nav_menu( 'header', __( 'Header menu', 'af' ) );
        } endif;
// FIM MENUS


// CRIA PRODUTOS

add_action( 'init', 'register_cpt_produto' );

function register_cpt_produto() {

    $labels = array(
        'name' => __( 'Produtos', 'produto' ),
        'singular_name' => __( 'Produto', 'produto' ),
        'add_new' => __( 'Novo', 'produto' ),
        'add_new_item' => __( 'Novo item', 'produto' ),
        'edit_item' => __( 'Editar item', 'produto' ),
        'new_item' => __( 'Novo item', 'produto' ),
        'view_item' => __( 'Ver item', 'produto' ),
        'view_items' => __( 'Ver Produtos', 'produto'),
        'search_items' => __( 'Buscar item', 'produto' ),
        'not_found' => __( 'Não encontrado', 'produto' ),
        'not_found_in_trash' => __( 'Não encontrado no lixo', 'produto' ),
        'parent_item_colon' => __( 'Item pai', 'produto' ),
        'all_items' => __( 'Todos os Produtos', 'produto'),
        'attributes' => __( 'Atributos do Produto', 'produto'),
        'insert_into_item' => __( 'Inserir Produto', 'produto'),
        'featured_image' => __( 'Foto do Produto', 'produto'),
        'set_featured_image' => __( 'Define Foto do Produto', 'produto'),
        'remove_featured_image' => __( 'Remove Foto do Produto', 'produto'),
        'use_featured_image' => __( 'Usar como Foto do Produto', 'produto'),
        'menu_name' => __( 'Produtos', 'produto' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'produtos', $args );
}

function cpt_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cpt_rewrite_flush' );




// EXTRAS

function bootstrap_wp_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'bootstrap_wp_setup' );

?>
