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
        <div class="header-actions">
          <button class="search-toggle" type="button" aria-expanded="false" aria-controls="header-search" data-search-toggle>
            <span class="screen-reader-text"><?php esc_html_e( 'Zoeken', 'yessin-starter' ); ?></span>
            <svg class="search-toggle__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M15.5 14h-.79l-.28-.27a6 6 0 1 0-1.41 1.41l.27.28v.79L21 20.5 20.5 21l-4.77-4.77v-.73zM10 15a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
            </svg>
          </button>
          <div class="header-search-inline" data-search-inline>
            <form class="header-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <label class="screen-reader-text" for="header-search-inline-input"><?php esc_html_e( 'Zoek naar:', 'yessin-starter' ); ?></label>
              <input type="search" id="header-search-inline-input" name="s" placeholder="<?php esc_attr_e( 'Zoek op de site…', 'yessin-starter' ); ?>" autocomplete="off" />
              <button class="header-search__submit" type="submit"><?php esc_html_e( 'Zoek', 'yessin-starter' ); ?></button>
            </form>
          </div>
          <div class="header-cta" data-header-cta>
            <a class="cta-button cta-button--secondary" href="<?php echo esc_url( home_url( '/doneer' ) ); ?>">
              <?php esc_html_e( 'Doneer', 'yessin-starter' ); ?>
            </a>
            <a class="cta-button cta-button--primary" href="<?php echo esc_url( home_url( '/word-lid' ) ); ?>">
              <?php esc_html_e( 'Word lid', 'yessin-starter' ); ?>
            </a>
          </div>
        </div>
      </nav>
      <div class="header-search" id="header-search" data-search-panel aria-hidden="true">
        <form class="header-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <label class="screen-reader-text" for="header-search-input"><?php esc_html_e( 'Zoek naar:', 'yessin-starter' ); ?></label>
          <input type="search" id="header-search-input" name="s" placeholder="<?php esc_attr_e( 'Zoek op de site…', 'yessin-starter' ); ?>" autocomplete="off" />
          <button class="header-search__submit" type="submit"><?php esc_html_e( 'Zoek', 'yessin-starter' ); ?></button>
          <button class="header-search__close" type="button" data-search-close aria-label="<?php esc_attr_e( 'Sluit zoeken', 'yessin-starter' ); ?>">
            <span aria-hidden="true">&times;</span>
          </button>
        </form>
      </div>
      <div class="nav-backdrop" aria-hidden="true"></div>
    </div>
  </header>
