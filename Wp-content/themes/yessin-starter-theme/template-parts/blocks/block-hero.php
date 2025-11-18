<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$eyebrow        = get_field( 'hero_eyebrow' );
$title          = get_field( 'hero_title' );
$text           = get_field( 'hero_text' );
$primary_cta    = get_field( 'hero_primary_cta' );
$secondary_cta  = get_field( 'hero_secondary_cta' );
$background     = get_field( 'hero_background' );
$overlay_color  = get_field( 'hero_overlay_color' ) ?: '#000000';
$overlay_amount = intval( get_field( 'hero_overlay_opacity' ) );
$align_class    = isset( $block['align'] ) ? 'align' . $block['align'] : '';
$id             = ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-' . $block['id'];
$is_preview     = isset( $block['is_preview'] ) && $block['is_preview'];

$overlay_amount = min( 100, max( 0, $overlay_amount ) );
$overlay_rgba   = sprintf(
  'rgba(%1$d, %2$d, %3$d, %4$s)',
  hexdec( substr( $overlay_color, 1, 2 ) ),
  hexdec( substr( $overlay_color, 3, 2 ) ),
  hexdec( substr( $overlay_color, 5, 2 ) ),
  number_format( $overlay_amount / 100, 2, '.', '' )
);

$is_empty = ! $title && ! $text && ! $eyebrow;
?>
<section id="<?php echo esc_attr( $id ); ?>" class="block-hero <?php echo esc_attr( $align_class ); ?> <?php echo $is_empty ? 'is-empty' : ''; ?>">
  <?php if ( $is_empty && $is_preview ) : ?>
    <div class="acf-block-placeholder">
      <div class="acf-block-placeholder__icon">
        <span class="dashicons dashicons-cover-image"></span>
      </div>
      <div class="acf-block-placeholder__label">Hero Header</div>
      <div class="acf-block-placeholder__instructions">Add a title to get started</div>
    </div>
  <?php else : ?>
    <?php if ( $background ) : ?>
      <div class="block-hero__media" aria-hidden="true">
        <img src="<?php echo esc_url( $background['url'] ); ?>" alt="">
      </div>
    <?php endif; ?>
    <div class="block-hero__overlay" style="background: <?php echo esc_attr( $overlay_rgba ); ?>"></div>
    <div class="block-hero__inner wrap">
      <div class="block-hero__content">
        <?php if ( $eyebrow ) : ?>
          <p class="block-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <?php if ( $title ) : ?>
          <h1 class="block-hero__title"><?php echo esc_html( $title ); ?></h1>
        <?php endif; ?>
        <?php if ( $text ) : ?>
          <div class="block-hero__text"><?php echo wpautop( wp_kses_post( $text ) ); ?></div>
        <?php endif; ?>
        <?php if ( $primary_cta || $secondary_cta ) : ?>
          <div class="block-hero__actions">
            <?php if ( $primary_cta ) : ?>
              <a class="btn btn--primary" href="<?php echo esc_url( $primary_cta['url'] ); ?>" target="<?php echo esc_attr( $primary_cta['target'] ?: '_self' ); ?>">
                <?php echo esc_html( $primary_cta['title'] ); ?>
              </a>
            <?php endif; ?>
            <?php if ( $secondary_cta ) : ?>
              <a class="btn btn--ghost" href="<?php echo esc_url( $secondary_cta['url'] ); ?>" target="<?php echo esc_attr( $secondary_cta['target'] ?: '_self' ); ?>">
                <?php echo esc_html( $secondary_cta['title'] ); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</section>
