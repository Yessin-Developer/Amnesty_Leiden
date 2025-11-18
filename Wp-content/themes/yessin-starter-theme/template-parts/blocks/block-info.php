<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$eyebrow     = get_field( 'info_eyebrow' );
$heading     = get_field( 'info_heading' );
$intro       = get_field( 'info_intro' );
$items       = get_field( 'info_items' );
$align_class = isset( $block['align'] ) ? 'align' . $block['align'] : '';
$id          = ! empty( $block['anchor'] ) ? $block['anchor'] : 'info-' . $block['id'];
$is_preview  = isset( $block['is_preview'] ) && $block['is_preview'];
$is_empty    = ! $heading && ! $items;
?>
<section id="<?php echo esc_attr( $id ); ?>" class="block-info <?php echo esc_attr( $align_class ); ?>">
  <?php if ( $is_empty && $is_preview ) : ?>
    <div class="acf-block-placeholder">
      <div class="acf-block-placeholder__icon">
        <span class="dashicons dashicons-awards"></span>
      </div>
      <div class="acf-block-placeholder__label">Info Highlight</div>
      <div class="acf-block-placeholder__instructions">Add a heading to get started</div>
    </div>
  <?php else : ?>
    <div class="wrap">
      <header class="block-info__header">
        <?php if ( $eyebrow ) : ?>
          <p class="block-info__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <?php if ( $heading ) : ?>
          <h2 class="block-info__title"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>
        <?php if ( $intro ) : ?>
          <div class="block-info__intro"><?php echo wpautop( wp_kses_post( $intro ) ); ?></div>
        <?php endif; ?>
      </header>

      <?php if ( $items ) : ?>
        <div class="block-info__grid">
          <?php foreach ( $items as $item ) : ?>
            <article class="block-info__item">
              <?php if ( ! empty( $item['icon'] ) ) : ?>
                <div class="block-info__icon">
                  <img src="<?php echo esc_url( $item['icon']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ?? '' ); ?>">
                </div>
              <?php endif; ?>
              <?php if ( ! empty( $item['title'] ) ) : ?>
                <h3><?php echo esc_html( $item['title'] ); ?></h3>
              <?php endif; ?>
              <?php if ( ! empty( $item['text'] ) ) : ?>
                <p><?php echo esc_html( $item['text'] ); ?></p>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>

