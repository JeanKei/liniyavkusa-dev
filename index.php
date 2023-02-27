<?php get_header(); ?>
  <main class="main">
    <section class="main-hero">
      <h1 class="main-title main-hero__title">Кейтеринг и гастробоксы</h1>
      <button class="main-hero__btn">Оставить заявку</button>
    </section>
    <div class="section-figure"></div>
    <div class="main-descr">
        <div class="container">
          <div class="main-descr__wrap">
            <p class="main-descr__text">Мы создаем идеальные закуски для любых событий и мероприятий. Доставляем готовые гастробоксы, собираем красивый стол в любой локации, а также обслуживаем мероприятия</p>
            <p class="main-descr__text">Наш шеф-повар всегда создает необыкновенные решения, а фуддекоратор самую уютную атмосферу</p>
          </div>
        </div>
    </div>
    <div class="menu-block"  id="menu">
      <div class="container">
        <?php
            if (has_nav_menu('our_menu')) {
              wp_nav_menu(array(
                'theme_location' => 'our_menu',
                'depth' => 1,
                'container' => false,
                'menu_class' => 'our-menu',
              ));
            }
        ?>
      </div>
    </div>
    <section class="products-block">
      <div class="container">
        <div id="subcategory-archive">
          <?php $terms = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'pad_counts'=> true,
            'order' => 'ID',
            'parent' => 0,
          ) ); ?>

          <?php if($terms) : ?>
          <?php foreach($terms as $term) : ?>

            <div class="subcategory" id="<?php echo $term->slug;?>">

            <a class="subcategory-image" href="<?php echo get_term_link($term->term_id);?>">
              <?php woocommerce_subcategory_thumbnail( $term );  ?>
            </a>
            <h2 class="subcategory-title">
              <a href="<?php echo get_term_link($term->term_id);?>">
                <?php echo $term->name;?>
              </a>
            </h2>
            <!-- <p class="count"><?php if ($term->count > 0) : ?><?php echo $term->count; ?><?php else: ?>0<?php endif; ?></p> -->
            <!--<div class="subcategory-descripton"><p><?php //if($term->description) : ?><?php //echo $term->description; ?><?php //else: ?>Описание термина таксономии<?php //endif; ?></p></div>-->

            <?php // Создаем массив терминов детей текущего термина текущей таксономии
            $tax = $term->taxonomy;
            $children_terms = get_terms( array(
              'taxonomy' => $tax,
              'hide_empty' => false,
              'parent' => $term->term_id,
            ) ); ?>

            <?php if($children_terms): // если есть дочерние категории ?>
            <ul><?php foreach ($children_terms as $children_term) : ?>
            <?php $link = get_term_link($children_term); ?>

              <li><a href="<?php echo $link ?>";><?php echo $children_term->name ?></a></li>
              <!--<p class="count"><?php //echo $children_term->count ?></p>-->

            <?php endforeach; ?></ul>
            <?php endif; // конец условия - если есть дочерние термины таксономии ?>

            </div>

          <?php endforeach; ?>
          <?php endif; ?>

        </div>
      </div>
    </section>
  </main>
<?php get_footer(); ?>

