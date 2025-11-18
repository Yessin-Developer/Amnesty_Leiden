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
  register_widget( 'Yessin_Image_Widget' );
  register_widget( 'Yessin_Paragraph_Widget' );
}
add_action( 'widgets_init', 'yessin_register_widgets' );

class Yessin_Image_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'yessin_image_widget',
      __( 'Image Block', 'yessin-starter' ),
      array( 'description' => __( 'Toont een afbeelding met optionele titel.', 'yessin-starter' ) )
    );
  }

  public function widget( $args, $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $image_url = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';

    if ( empty( $image_url ) ) {
      return;
    }

    echo $args['before_widget'];

    if ( ! empty( $title ) ) {
      echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
    }

    printf(
      '<figure class="image-widget"><img src="%1$s" alt="%2$s"></figure>',
      esc_url( $image_url ),
      esc_attr( $title )
    );

    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = isset( $instance['title'] ) ? $instance['title'] : '';
    $image_url = isset( $instance['image_url'] ) ? $instance['image_url'] : '';
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Titel:', 'yessin-starter' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php esc_html_e( 'Afbeelding URL:', 'yessin-starter' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="url" value="<?php echo esc_attr( $image_url ); ?>" placeholder="https://">
      <small><?php esc_html_e( 'Upload een afbeelding in de mediabibliotheek en plak hier de URL.', 'yessin-starter' ); ?></small>
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
    $instance['image_url'] = isset( $new_instance['image_url'] ) ? esc_url_raw( $new_instance['image_url'] ) : '';

    return $instance;
  }
}

class Yessin_Paragraph_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'yessin_paragraph_widget',
      __( 'Paragraaf', 'yessin-starter' ),
      array( 'description' => __( 'Voegt een tekstblok met titel toe.', 'yessin-starter' ) )
    );
  }

  public function widget( $args, $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $content = ! empty( $instance['content'] ) ? $instance['content'] : '';

    if ( empty( $content ) ) {
      return;
    }

    echo $args['before_widget'];

    if ( ! empty( $title ) ) {
      echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
    }

    printf(
      '<div class="paragraph-widget__text">%s</div>',
      wpautop( wp_kses_post( $content ) )
    );

    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = isset( $instance['title'] ) ? $instance['title'] : '';
    $content = isset( $instance['content'] ) ? $instance['content'] : '';
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Titel:', 'yessin-starter' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Paragraaf tekst:', 'yessin-starter' ); ?></label>
      <textarea class="widefat" rows="6" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"><?php echo esc_textarea( $content ); ?></textarea>
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
    $instance['content'] = isset( $new_instance['content'] ) ? wp_kses_post( $new_instance['content'] ) : '';

    return $instance;
  }
}

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

function yessin_register_block_category( $categories ) {
  return array_merge(
    array(
      array(
        'slug'  => 'amnesty-blocks',
        'title' => __( 'Amnesty Blocks', 'yessin-starter' ),
        'icon'  => 'block-default',
      ),
    ),
    $categories
  );
}
add_filter( 'block_categories_all', 'yessin_register_block_category', 10, 1 );

function yessin_register_acf_blocks() {
  if ( ! function_exists( 'acf_register_block_type' ) ) return;

  acf_register_block_type(array(
    'name'              => 'hero',
    'title'             => __('Hero Header'),
    'description'       => __('Full-width hero section with background image and CTAs'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-hero.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'cover-image',
    'keywords'          => array('hero','intro','header'),
    'mode'              => 'preview',
    'supports'          => array(
      'align'   => array( 'wide', 'full' ),
      'anchor'  => true,
      'spacing' => array(
        'padding' => true,
        'margin'  => true,
      ),
    ),
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
        'data' => array(
          'hero_title' => 'Hero Block',
        )
      )
    ),
  ));

  acf_register_block_type(array(
    'name'              => 'cards',
    'title'             => __('Cards'),
    'description'       => __('Grid of cards with custom content'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-cards.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'screenoptions',
    'keywords'          => array('cards','grid'),
    'mode'              => 'preview',
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
      )
    ),
  ));

  acf_register_block_type(array(
    'name'              => 'faq',
    'title'             => __('FAQ'),
    'description'       => __('Frequently asked questions accordion'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-faq.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'editor-help',
    'keywords'          => array('faq','accordion'),
    'mode'              => 'preview',
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
      )
    ),
  ));

  acf_register_block_type(array(
    'name'              => 'info-highlight',
    'title'             => __('Info Highlight'),
    'description'       => __('Highlight key information in a grid layout'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-info.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'awards',
    'keywords'          => array('info','columns','stats'),
    'mode'              => 'preview',
    'supports'          => array(
      'align'  => array( 'wide', 'full' ),
      'anchor' => true,
    ),
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
        'data' => array(
          'info_heading' => 'Info Highlight Block',
        )
      )
    ),
  ));

  acf_register_block_type(array(
    'name'              => 'news-list',
    'title'             => __('News Grid'),
    'description'       => __('Display latest news posts in a grid'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-news.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'excerpt-view',
    'keywords'          => array('news','posts','updates'),
    'mode'              => 'preview',
    'supports'          => array(
      'align'  => array( 'wide', 'full' ),
      'anchor' => true,
    ),
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
        'data' => array(
          'news_heading' => 'News Grid Block',
        )
      )
    ),
  ));

  acf_register_block_type(array(
    'name'              => 'contact-info',
    'title'             => __('Contact Info'),
    'description'       => __('Display contact details with optional CTA'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-contact.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'email',
    'keywords'          => array('contact','details','info'),
    'mode'              => 'preview',
    'supports'          => array(
      'align'  => array( 'wide', 'full' ),
      'anchor' => true,
    ),
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
        'data' => array(
          'contact_heading' => 'Contact Info Block',
        )
      )
    ),
  ));

  acf_register_block_type(array(
    'name'              => 'cta-banner',
    'title'             => __('CTA Banner'),
    'description'       => __('Call-to-action banner with dual buttons'),
    'render_template'   => get_template_directory() . '/template-parts/blocks/block-banner.php',
    'category'          => 'amnesty-blocks',
    'icon'              => 'megaphone',
    'keywords'          => array('cta','banner','buttons'),
    'mode'              => 'preview',
    'supports'          => array(
      'align'  => array( 'wide', 'full' ),
      'anchor' => true,
    ),
    'example'           => array(
      'attributes' => array(
        'mode' => 'preview',
        'data' => array(
          'banner_title' => 'CTA Banner Block',
        )
      )
    ),
  ));
}
add_action( 'acf/init', 'yessin_register_acf_blocks' );

function yessin_register_acf_field_groups() {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
  }

  acf_add_local_field_group(array(
    'key' => 'group_hero_header',
    'title' => __( 'Block: Hero Header', 'yessin-starter' ),
    'fields' => array(
      array(
        'key' => 'field_hero_eyebrow',
        'label' => __( 'Eyebrow', 'yessin-starter' ),
        'name' => 'hero_eyebrow',
        'type' => 'text',
      ),
      array(
        'key' => 'field_hero_title',
        'label' => __( 'Title', 'yessin-starter' ),
        'name' => 'hero_title',
        'type' => 'text',
        'wrapper' => array( 'width' => '60' ),
      ),
      array(
        'key' => 'field_hero_text',
        'label' => __( 'Description', 'yessin-starter' ),
        'name' => 'hero_text',
        'type' => 'textarea',
        'rows' => 3,
      ),
      array(
        'key' => 'field_hero_primary_cta',
        'label' => __( 'Primary CTA', 'yessin-starter' ),
        'name' => 'hero_primary_cta',
        'type' => 'link',
        'return_format' => 'array',
      ),
      array(
        'key' => 'field_hero_secondary_cta',
        'label' => __( 'Secondary CTA', 'yessin-starter' ),
        'name' => 'hero_secondary_cta',
        'type' => 'link',
        'return_format' => 'array',
      ),
      array(
        'key' => 'field_hero_background',
        'label' => __( 'Background Image', 'yessin-starter' ),
        'name' => 'hero_background',
        'type' => 'image',
        'return_format' => 'array',
        'preview_size' => 'large',
      ),
      array(
        'key' => 'field_hero_overlay_color',
        'label' => __( 'Overlay Color', 'yessin-starter' ),
        'name' => 'hero_overlay_color',
        'type' => 'color_picker',
        'default_value' => '#000000',
      ),
      array(
        'key' => 'field_hero_overlay_opacity',
        'label' => __( 'Overlay Opacity (%)', 'yessin-starter' ),
        'name' => 'hero_overlay_opacity',
        'type' => 'number',
        'default_value' => 60,
        'min' => 0,
        'max' => 90,
        'append' => '%',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/hero',
        ),
      ),
    ),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_info_highlight',
    'title' => __( 'Block: Info Highlight', 'yessin-starter' ),
    'fields' => array(
      array(
        'key' => 'field_info_eyebrow',
        'label' => __( 'Eyebrow', 'yessin-starter' ),
        'name' => 'info_eyebrow',
        'type' => 'text',
      ),
      array(
        'key' => 'field_info_heading',
        'label' => __( 'Heading', 'yessin-starter' ),
        'name' => 'info_heading',
        'type' => 'text',
        'required' => 1,
      ),
      array(
        'key' => 'field_info_intro',
        'label' => __( 'Intro Text', 'yessin-starter' ),
        'name' => 'info_intro',
        'type' => 'textarea',
        'rows' => 3,
      ),
      array(
        'key' => 'field_info_items',
        'label' => __( 'Info Items', 'yessin-starter' ),
        'name' => 'info_items',
        'type' => 'repeater',
        'min' => 1,
        'layout' => 'row',
        'button_label' => __( 'Add info item', 'yessin-starter' ),
        'sub_fields' => array(
          array(
            'key' => 'field_info_item_icon',
            'label' => __( 'Icon', 'yessin-starter' ),
            'name' => 'icon',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
          ),
          array(
            'key' => 'field_info_item_title',
            'label' => __( 'Title', 'yessin-starter' ),
            'name' => 'title',
            'type' => 'text',
            'required' => 1,
          ),
          array(
            'key' => 'field_info_item_text',
            'label' => __( 'Text', 'yessin-starter' ),
            'name' => 'text',
            'type' => 'textarea',
            'rows' => 3,
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/info-highlight',
        ),
      ),
    ),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_news_grid',
    'title' => __( 'Block: News Grid', 'yessin-starter' ),
    'fields' => array(
      array(
        'key' => 'field_news_heading',
        'label' => __( 'Heading', 'yessin-starter' ),
        'name' => 'news_heading',
        'type' => 'text',
        'required' => 1,
      ),
      array(
        'key' => 'field_news_intro',
        'label' => __( 'Intro', 'yessin-starter' ),
        'name' => 'news_intro',
        'type' => 'textarea',
        'rows' => 3,
      ),
      array(
        'key' => 'field_news_posts_to_show',
        'label' => __( 'Posts to show', 'yessin-starter' ),
        'name' => 'news_posts_to_show',
        'type' => 'number',
        'default_value' => 3,
        'min' => 1,
        'max' => 6,
      ),
      array(
        'key' => 'field_news_category',
        'label' => __( 'Limit to category', 'yessin-starter' ),
        'name' => 'news_category',
        'type' => 'taxonomy',
        'taxonomy' => 'category',
        'field_type' => 'select',
        'allow_null' => 1,
        'return_format' => 'object',
      ),
      array(
        'key' => 'field_news_cta',
        'label' => __( 'Archive CTA', 'yessin-starter' ),
        'name' => 'news_cta',
        'type' => 'link',
        'return_format' => 'array',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/news-list',
        ),
      ),
    ),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_contact_info',
    'title' => __( 'Block: Contact Info', 'yessin-starter' ),
    'fields' => array(
      array(
        'key' => 'field_contact_heading',
        'label' => __( 'Heading', 'yessin-starter' ),
        'name' => 'contact_heading',
        'type' => 'text',
      ),
      array(
        'key' => 'field_contact_intro',
        'label' => __( 'Intro', 'yessin-starter' ),
        'name' => 'contact_intro',
        'type' => 'textarea',
        'rows' => 3,
      ),
      array(
        'key' => 'field_contact_items',
        'label' => __( 'Contact lines', 'yessin-starter' ),
        'name' => 'contact_items',
        'type' => 'repeater',
        'layout' => 'row',
        'button_label' => __( 'Add contact line', 'yessin-starter' ),
        'sub_fields' => array(
          array(
            'key' => 'field_contact_item_label',
            'label' => __( 'Label', 'yessin-starter' ),
            'name' => 'label',
            'type' => 'text',
            'wrapper' => array( 'width' => '30' ),
          ),
          array(
            'key' => 'field_contact_item_value',
            'label' => __( 'Value', 'yessin-starter' ),
            'name' => 'value',
            'type' => 'text',
            'wrapper' => array( 'width' => '35' ),
          ),
          array(
            'key' => 'field_contact_item_link',
            'label' => __( 'Link (optional)', 'yessin-starter' ),
            'name' => 'link',
            'type' => 'link',
            'return_format' => 'array',
            'wrapper' => array( 'width' => '35' ),
          ),
        ),
      ),
      array(
        'key' => 'field_contact_cta',
        'label' => __( 'CTA Link', 'yessin-starter' ),
        'name' => 'contact_cta',
        'type' => 'link',
        'return_format' => 'array',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/contact-info',
        ),
      ),
    ),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_cta_banner',
    'title' => __( 'Block: CTA Banner', 'yessin-starter' ),
    'fields' => array(
      array(
        'key' => 'field_banner_label',
        'label' => __( 'Label', 'yessin-starter' ),
        'name' => 'banner_label',
        'type' => 'text',
      ),
      array(
        'key' => 'field_banner_title',
        'label' => __( 'Title', 'yessin-starter' ),
        'name' => 'banner_title',
        'type' => 'text',
        'required' => 1,
      ),
      array(
        'key' => 'field_banner_text',
        'label' => __( 'Text', 'yessin-starter' ),
        'name' => 'banner_text',
        'type' => 'textarea',
        'rows' => 3,
      ),
      array(
        'key' => 'field_banner_primary_cta',
        'label' => __( 'Primary CTA', 'yessin-starter' ),
        'name' => 'banner_primary_cta',
        'type' => 'link',
        'return_format' => 'array',
      ),
      array(
        'key' => 'field_banner_secondary_cta',
        'label' => __( 'Secondary CTA', 'yessin-starter' ),
        'name' => 'banner_secondary_cta',
        'type' => 'link',
        'return_format' => 'array',
      ),
      array(
        'key' => 'field_banner_background_color',
        'label' => __( 'Background Color', 'yessin-starter' ),
        'name' => 'banner_background_color',
        'type' => 'color_picker',
        'default_value' => '#f5b700',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/cta-banner',
        ),
      ),
    ),
  ));
}
add_action( 'acf/init', 'yessin_register_acf_field_groups' );
?>