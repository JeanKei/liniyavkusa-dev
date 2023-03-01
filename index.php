<?php get_header(); ?>
  <!-- <main class="main"> -->
    <?php if(have_posts() ) : ?>

      <?php while( have_posts() ) : the_post(); ?>
        <?php the_content() ?>
      <?php endwhile; ?>

    <?else : ?>
      <p>Ничеге не найдено</p>
    <?php endif; ?>

  <!-- </main> -->
<?php get_footer(); ?>

