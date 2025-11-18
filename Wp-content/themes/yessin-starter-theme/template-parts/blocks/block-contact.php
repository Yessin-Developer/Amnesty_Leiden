<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$heading     = get_field( 'contact_heading' );
$intro       = get_field( 'contact_intro' );
$items       = get_field( 'contact_items' );
$cta         = get_field( 'contact_cta' );
$align_class = isset( $block['align'] ) ? 'align' . $block['align'] : '';
$id          = ! empty( $block['anchor'] ) ? $block['anchor'] : 'contact-' . $block['id'];
$is_preview  = isset( $block['is_preview'] ) && $block['is_preview'];
$is_empty    = ! $heading && ! $items;
?>
<section id="<?php echo esc_attr( $id ); ?>" class="block-contact <?php echo esc_attr( $align_class ); ?>">
  <?php if ( $is_empty && $is_preview ) : ?>
    <div class="acf-block-placeholder">
      <div class="acf-block-placeholder__icon">
        <span class="dashicons dashicons-email"></span>
      </div>
      <div class="acf-block-placeholder__label">Contact Info</div>
      <div class="acf-block-placeholder__instructions">Add a heading and contact details</div>
    </div>
  <?php else : ?>
    <div class="wrap block-contact__inner">
      <div class="block-contact__content">
        <?php if ( $heading ) : ?>
          <h2><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>
        <?php if ( $intro ) : ?>
          <div class="block-contact__intro"><?php echo wpautop( wp_kses_post( $intro ) ); ?></div>
        <?php endif; ?>
      </div>

      <?php if ( $items ) : ?>
        <ul class="block-contact__details">
          <?php foreach ( $items as $item ) : ?>
            <li>
              <?php if ( ! empty( $item['label'] ) ) : ?>
                <span class="block-contact__label"><?php echo esc_html( $item['label'] ); ?></span>
              <?php endif; ?>
              <?php if ( ! empty( $item['link'] ) ) : ?>
                <a href="<?php echo esc_url( $item['link']['url'] ); ?>" target="<?php echo esc_attr( $item['link']['target'] ?: '_self' ); ?>">
                  <?php echo esc_html( $item['link']['title'] ?: $item['value'] ); ?>
                </a>
              <?php elseif ( ! empty( $item['value'] ) ) : ?>
                <span><?php echo esc_html( $item['value'] ); ?></span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if ( $cta ) : ?>
        <div class="block-contact__cta">
          <a class="btn" href="<?php echo esc_url( $cta['url'] ); ?>" target="<?php echo esc_attr( $cta['target'] ?: '_self' ); ?>">
            <?php echo esc_html( $cta['title'] ); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>

