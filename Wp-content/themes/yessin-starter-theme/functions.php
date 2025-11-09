<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function yessin_setup() {
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'align-wide' );
  add_theme_support( 'wp-block-styles' );
  add_theme_support( 'editor-styles' );
  add_theme_support( 'responsive-embeds' );

  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'yessin-starter' ),
    'footer'  => __( 'Footer Menu', 'yessin-starter' ),
    'header_cta' => __( 'Header CTA Menu', 'yessin-starter' ),
  ) );
}
add_action( 'after_setup_theme', 'yessin_setup' );

function yessin_register_sidebars() {
  register_sidebar( array(
    'name'          => __( 'Footer Brand', 'yessin-starter' ),
    'id'            => 'footer-brand',
    'description'   => __( 'Logo of korte intro voor in de footer', 'yessin-starter' ),
    'before_widget' => '<div class="footer-widget footer-widget--brand">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-widget__title">',
    'after_title'   => '</h3>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Footer Social', 'yessin-starter' ),
    'id'            => 'footer-social',
    'description'   => __( 'Social media icoontjes of links', 'yessin-starter' ),
    'before_widget' => '<div class="footer-widget footer-widget--social">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-widget__title">',
    'after_title'   => '</h3>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Footer Contact', 'yessin-starter' ),
    'id'            => 'footer-contact',
    'description'   => __( 'Contactinformatie voor in de footer', 'yessin-starter' ),
    'before_widget' => '<div class="footer-widget footer-widget--contact">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-widget__title">',
    'after_title'   => '</h3>',
  ) );
}
add_action( 'widgets_init', 'yessin_register_sidebars' );

function yessin_enqueue_assets() {
  wp_enqueue_style( 'yessin-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) );
  wp_enqueue_script( 'yessin-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), filemtime( get_template_directory() . '/assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'yessin_enqueue_assets' );

function yessin_editor_assets() {
  wp_enqueue_style( 'yessin-editor-css', get_template_directory_uri() . '/assets/css/editor-style.css', array(), filemtime( get_template_directory() . '/assets/css/editor-style.css' ) );
  wp_enqueue_script( 'yessin-editor-js', get_template_directory_uri() . '/build/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_template_directory() . '/build/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'yessin_editor_assets' );

function yessin_register_acf_blocks() {
  if ( ! function_exists( 'acf_register_block_type' ) ) return;

  acf_register_block_type(array(
    'name'              => 'hero',
    'title'             => __('Hero'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-hero.php',
    'category'          => 'layout',
    'icon'              => 'cover-image',
    'keywords'          => array('hero','intro'),
    'mode'              => 'preview',
    'supports'          => array( 'align' => true ),
  ));

  acf_register_block_type(array(
    'name'              => 'cards',
    'title'             => __('Cards'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-cards.php',
    'category'          => 'widgets',
    'icon'              => 'screenoptions',
    'keywords'          => array('cards','grid'),
  ));

  acf_register_block_type(array(
    'name'              => 'faq',
    'title'             => __('FAQ'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-faq.php',
    'category'          => 'widgets',
    'icon'              => 'editor-help',
    'keywords'          => array('faq','accordion'),
  ));
}
add_action( 'acf/init', 'yessin_register_acf_blocks' );
?>