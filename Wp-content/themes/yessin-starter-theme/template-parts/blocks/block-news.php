<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$heading     = get_field( 'news_heading' );
$intro       = get_field( 'news_intro' );
$limit       = (int) get_field( 'news_posts_to_show' ) ?: 3;
$category    = get_field( 'news_category' );
$cta         = get_field( 'news_cta' );
$align_class = isset( $block['align'] ) ? 'align' . $block['align'] : '';
$id          = ! empty( $block['anchor'] ) ? $block['anchor'] : 'news-' . $block['id'];
$is_preview  = isset( $block['is_preview'] ) && $block['is_preview'];

$query_args = array(
  'post_type'           => 'post',
  'posts_per_page'      => $limit,
  'ignore_sticky_posts' => true,
  'post_status'         => 'publish',
);

if ( $category ) {
  $query_args['tax_query'] = array(
    array(
      'taxonomy' => 'category',
      'terms'    => $category->term_id,
    ),
  );
}

$news_query = new WP_Query( $query_args );
$is_empty = ! $heading && ! $news_query->have_posts();
?>
<section id="<?php echo esc_attr( $id ); ?>" class="block-news <?php echo esc_attr( $align_class ); ?>">
  <?php if ( $is_empty && $is_preview && ! $heading ) : ?>
    <div class="acf-block-placeholder">
      <div class="acf-block-placeholder__icon">
        <span class="dashicons dashicons-excerpt-view"></span>
      </div>
      <div class="acf-block-placeholder__label">News Grid</div>
      <div class="acf-block-placeholder__instructions">Configure settings to display news posts</div>
    </div>
  <?php else : ?>
    <div class="wrap">
    <header class="block-news__header">
      <?php if ( $heading ) : ?>
        <h2><?php echo esc_html( $heading ); ?></h2>
      <?php endif; ?>
      <?php if ( $intro ) : ?>
        <p class="block-news__intro"><?php echo esc_html( $intro ); ?></p>
      <?php endif; ?>
    </header>

    <?php if ( $news_query->have_posts() ) : ?>
      <div class="block-news__grid">
        <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
          <article class="news-card">
            <a class="news-card__media" href="<?php the_permalink(); ?>">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large' ); ?>
              <?php else : ?>
                <div class="news-card__placeholder"></div>
              <?php endif; ?>
            </a>
            <div class="news-card__body">
              <p class="news-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
              <a class="news-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'yessin-starter' ); ?></a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <p class="block-news__empty"><?php esc_html_e( 'No news items found.', 'yessin-starter' ); ?></p>
    <?php endif; ?>

    <?php if ( $cta ) : ?>
      <div class="block-news__footer">
        <a class="btn" href="<?php echo esc_url( $cta['url'] ); ?>" target="<?php echo esc_attr( $cta['target'] ?: '_self' ); ?>">
          <?php echo esc_html( $cta['title'] ); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</section>

