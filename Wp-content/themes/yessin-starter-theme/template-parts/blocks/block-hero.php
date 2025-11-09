<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$heading = get_field('heading');
$subheading = get_field('subheading');
$background = get_field('background');
$cta = get_field('cta');
$align = isset($block['align']) ? 'align' . $block['align'] : '';
?>
<section class="block-hero <?php echo esc_attr($align); ?>" style="<?php if($background): ?>background-image:url('<?php echo esc_url($background['url']); ?>');<?php endif; ?>">
  <div class="wrap">
    <?php if($heading): ?><h1 class="hero-heading"><?php echo esc_html($heading); ?></h1><?php endif; ?>
    <?php if($subheading): ?><p class="hero-subheading"><?php echo esc_html($subheading); ?></p><?php endif; ?>
    <?php if($cta): ?><a class="btn hero-cta" href="<?php echo esc_url($cta['url']); ?>"><?php echo esc_html($cta['title']); ?></a><?php endif; ?>
  </div>
</section>
