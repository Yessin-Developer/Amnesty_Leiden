<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php $faqs = get_field('faqs'); ?>
<section class="block-faq">
  <div class="wrap">
    <?php if($faqs): foreach($faqs as $faq): ?>
      <details class="faq-item"><summary><?php echo esc_html($faq['question']); ?></summary><div class="faq-answer"><?php echo wp_kses_post($faq['answer']); ?></div></details>
    <?php endforeach; endif; ?>
  </div>
</section>
