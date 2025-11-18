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

class Yessin_Social_Media_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'yessin_social_media',
      __( 'Social Media', 'yessin-starter' ),
      array( 'description' => __( 'Toont maximaal vier social media iconen met links.', 'yessin-starter' ) )
    );
  }

  public function widget( $args, $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Volg ons', 'yessin-starter' );
    $networks = $this->get_networks( $instance );

    echo $args['before_widget'];

    if ( ! empty( $title ) ) {
      echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
    }

    echo '<ul class="social-media-widget__list">';

    foreach ( $networks as $network => $url ) {
      if ( empty( $url ) ) {
        continue;
      }

      $icon = $this->get_icon_svg( $network );

      printf(
        '<li><a class="social-media-widget__link social-media-widget__link--%1$s" href="%2$s" target="_blank" rel="noopener noreferrer">%3$s<span class="screen-reader-text">%4$s</span></a></li>',
        esc_attr( $network ),
        esc_url( $url ),
        $icon,
        esc_html( ucfirst( $network ) )
      );
    }

    echo '</ul>';
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Volg ons', 'yessin-starter' );
    $networks = $this->get_networks( $instance );
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Titel:', 'yessin-starter' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php foreach ( $networks as $network => $value ) : ?>
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( $network ) ); ?>">
          <?php echo esc_html( ucfirst( $network ) . ' URL:' ); ?>
        </label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $network ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $network ) ); ?>" type="url" value="<?php echo esc_attr( $value ); ?>" placeholder="https://">
      </p>
    <?php endforeach; ?>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );

    foreach ( array( 'facebook', 'instagram', 'twitter', 'linkedin' ) as $network ) {
      $instance[ $network ] = isset( $new_instance[ $network ] ) ? esc_url_raw( $new_instance[ $network ] ) : '';
    }

    return $instance;
  }

  private function get_networks( $instance ) {
    $defaults = array(
      'facebook'  => '',
      'instagram' => '',
      'twitter'   => '',
      'linkedin'  => '',
    );

    return wp_parse_args( $instance, $defaults );
  }

  private function get_icon_svg( $network ) {
    $icons = array(
      'facebook'  => '<svg aria-hidden="true" viewBox="0 0 24 24"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2v-2c0-.9.3-1.6 1.7-1.6h1.6V4.2c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H8v3.2h2.7V22h2.8z"/></svg>',
      'instagram' => '<svg aria-hidden="true" viewBox="0 0 24 24"><path d="M7 2h10c2.8 0 5 2.2 5 5v10c0 2.8-2.2 5-5 5H7c-2.8 0-5-2.2-5-5V7c0-2.8 2.2-5 5-5zm0 2C5.3 4 4 5.3 4 7v10c0 1.7 1.3 3 3 3h10c1.7 0 3-1.3 3-3V7c0-1.7-1.3-3-3-3H7zm5 3.4A5.6 5.6 0 0 1 17.6 13 5.6 5.6 0 0 1 12 18.6 5.6 5.6 0 0 1 6.4 13 5.6 5.6 0 0 1 12 7.4zm0 2.2A3.4 3.4 0 0 0 8.6 13 3.4 3.4 0 0 0 12 16.4 3.4 3.4 0 0 0 15.4 13 3.4 3.4 0 0 0 12 9.6zm5.2-3.8a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4z"/></svg>',
      'twitter'   => '<svg aria-hidden="true" viewBox="0 0 24 24"><path d="M22 5.8c-.7.3-1.4.5-2.2.6a3.7 3.7 0 0 0 1.6-2 7.4 7.4 0 0 1-2.4.9 3.6 3.6 0 0 0-6.1 3.3 10.2 10.2 0 0 1-7.4-3.8 3.6 3.6 0 0 0 1.1 4.8c-.6 0-1.2-.2-1.7-.5v.1c0 1.7 1.2 3.2 2.8 3.6-.5.1-1 .2-1.5.1.4 1.3 1.7 2.3 3.2 2.3a7.3 7.3 0 0 1-4.5 1.5H4a10.3 10.3 0 0 0 15.8-8.7v-.4c.7-.5 1.4-1.2 1.9-2z"/></svg>',
      'linkedin'  => '<svg aria-hidden="true" viewBox="0 0 24 24"><path d="M6.5 9H3V21h3.5V9zM4.7 3.5a2 2 0 1 0 0 4.1 2 2 0 0 0 0-4.1zM21 21h-3.5v-6.4c0-1.5-.6-2.5-1.9-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V21H10c.1-8.7 0-9.6 0-12h3.5v1.9c.5-.8 1.3-2 3.4-2 2.5 0 4.1 1.6 4.1 5V21z"/></svg>',
    );

    return $icons[ $network ] ?? '';
  }
}

function yessin_register_widgets() {
  register_widget( 'Yessin_Social_Media_Widget' );
}
add_action( 'widgets_init', 'yessin_register_widgets' );

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