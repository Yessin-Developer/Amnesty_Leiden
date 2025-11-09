  <footer class="site-footer">
    <div class="wrap footer-grid">
      <div class="footer-column footer-column--brand">
        <?php if ( is_active_sidebar( 'footer-brand' ) ) : ?>
          <?php dynamic_sidebar( 'footer-brand' ); ?>
        <?php else : ?>
          <div class="footer-widget footer-widget--brand">
            <h3 class="footer-widget__title"><?php bloginfo( 'name' ); ?></h3>
            <p><?php bloginfo( 'description' ); ?></p>
          </div>
        <?php endif; ?>
      </div>

      <div class="footer-column footer-column--menu">
        <h3 class="footer-widget__title"><?php esc_html_e( 'Navigatie', 'yessin-starter' ); ?></h3>
        <?php
          wp_nav_menu( array(
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'footer-menu',
            'fallback_cb'    => false,
          ) );
        ?>
      </div>

      <div class="footer-column footer-column--social">
        <?php if ( is_active_sidebar( 'footer-social' ) ) : ?>
          <?php dynamic_sidebar( 'footer-social' ); ?>
        <?php else : ?>
          <div class="footer-widget footer-widget--social">
            <h3 class="footer-widget__title"><?php esc_html_e( 'Volg ons', 'yessin-starter' ); ?></h3>
            <p><?php esc_html_e( 'Voeg hier sociale links toe via Widgets.', 'yessin-starter' ); ?></p>
          </div>
        <?php endif; ?>
      </div>

      <div class="footer-column footer-column--contact">
        <?php if ( is_active_sidebar( 'footer-contact' ) ) : ?>
          <?php dynamic_sidebar( 'footer-contact' ); ?>
        <?php else : ?>
          <div class="footer-widget footer-widget--contact">
            <h3 class="footer-widget__title"><?php esc_html_e( 'Contact', 'yessin-starter' ); ?></h3>
            <p><?php esc_html_e( 'Voeg contactinformatie toe via Widgets.', 'yessin-starter' ); ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="footer-meta">
      <div class="wrap footer-meta__inner">
        <span>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></span>
        <span><?php esc_html_e( 'Alle rechten voorbehouden.', 'yessin-starter' ); ?></span>
      </div>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>
</html>
