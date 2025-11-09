<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php $cards = get_field('cards'); ?>
<section class="block-cards">
  <div class="wrap">
    <div class="cards-grid">
      <?php if($cards): foreach($cards as $card): ?>
        <article class="card">
          <?php if(!empty($card['image'])): ?>
            <img src="<?php echo esc_url($card['image']['sizes']['medium']); ?>" alt="">
          <?php endif; ?>
          <h3><?php echo esc_html($card['title']); ?></h3>
          <p><?php echo esc_html($card['excerpt']); ?></p>
          <?php if(!empty($card['link'])): ?><a href="<?php echo esc_url($card['link']); ?>" class="btn">Lees meer</a><?php endif; ?>
        </article>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
