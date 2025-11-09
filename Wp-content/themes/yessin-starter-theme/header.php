<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="site-header">
    <div class="wrap">
      <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__label"><?php esc_html_e( 'Menu', 'yessin-starter' ); ?></span>
      </button>
      <nav class="site-nav" data-site-nav id="primary-menu">
        <?php
          wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'primary-menu',
            'fallback_cb'    => false,
          ) );
        ?>
        <div class="header-cta" data-header-cta>
          <a class="cta-button cta-button--secondary" href="<?php echo esc_url( home_url( '/doneer' ) ); ?>">
            <?php esc_html_e( 'Doneer', 'yessin-starter' ); ?>
          </a>
          <a class="cta-button cta-button--primary" href="<?php echo esc_url( home_url( '/word-lid' ) ); ?>">
            <?php esc_html_e( 'Word lid', 'yessin-starter' ); ?>
          </a>
        </div>
      </nav>
      <div class="nav-backdrop" aria-hidden="true"></div>
    </div>
  </header>
