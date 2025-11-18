<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$label        = get_field( 'banner_label' );
$title        = get_field( 'banner_title' );
$text         = get_field( 'banner_text' );
$primary_cta  = get_field( 'banner_primary_cta' );
$secondary_cta= get_field( 'banner_secondary_cta' );
$background   = get_field( 'banner_background_color' ) ?: '#f5b700';
$align_class  = isset( $block['align'] ) ? 'align' . $block['align'] : '';
$id           = ! empty( $block['anchor'] ) ? $block['anchor'] : 'banner-' . $block['id'];
$is_preview   = isset( $block['is_preview'] ) && $block['is_preview'];
$is_empty     = ! $title && ! $text;
?>
<section id="<?php echo esc_attr( $id ); ?>" class="block-banner <?php echo esc_attr( $align_class ); ?>" style="--banner-bg: <?php echo esc_attr( $background ); ?>">
  <?php if ( $is_empty && $is_preview ) : ?>
    <div class="acf-block-placeholder">
      <div class="acf-block-placeholder__icon">
        <span class="dashicons dashicons-megaphone"></span>
      </div>
      <div class="acf-block-placeholder__label">CTA Banner</div>
      <div class="acf-block-placeholder__instructions">Add a title and call-to-action buttons</div>
    </div>
  <?php else : ?>
    <div class="wrap block-banner__inner">
      <div class="block-banner__content">
        <?php if ( $label ) : ?>
          <p class="block-banner__label"><?php echo esc_html( $label ); ?></p>
        <?php endif; ?>
        <?php if ( $title ) : ?>
          <h2><?php echo esc_html( $title ); ?></h2>
        <?php endif; ?>
        <?php if ( $text ) : ?>
          <p><?php echo esc_html( $text ); ?></p>
        <?php endif; ?>
      </div>
      <div class="block-banner__actions">
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
    </div>
  <?php endif; ?>
</section>

