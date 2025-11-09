<?php get_header(); ?>
<main class="wrap">
  <?php if(have_posts()): while(have_posts()): the_post(); the_content(); endwhile; else: echo '<p>Geen content</p>'; endif; ?>
</main>
<?php get_footer(); ?>
