<?php

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>


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

          <?php
          /**
          * Hook: woocommerce_before_main_content.
          *
          * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
          * @hooked woocommerce_breadcrumb - 20
          * @hooked WC_Structured_Data::generate_website_data() - 30
          */
          do_action( 'woocommerce_before_main_content' );

          if ( woocommerce_product_loop() ) {

              /**
              * Hook: woocommerce_before_shop_loop.
              *
              * @hooked wc_print_notices - 10
              * @hooked woocommerce_result_count - 20
              * @hooked woocommerce_catalog_ordering - 30
              */
              do_action( 'woocommerce_before_shop_loop' );



              if ( wc_get_loop_prop( 'total' ) ) {

                      /* Start my loop section */
                      foreach( get_terms( array( 'taxonomy' => 'product_cat' ) ) as $category ) :
                          $products_loop = new WP_Query( array(
                              'post_type' => 'product',

                              'showposts' => -1,

                              'tax_query' => array_merge( array(
                                  'relation'  => 'AND',
                                  array(
                                      'taxonomy' => 'product_cat',
                                      'terms'    => array( $category->term_id ),
                                      'field'   => 'term_id'
                                  )
                              ), WC()->query->get_tax_query() ),

                              'meta_query' => array_merge( array(

                              // You can optionally add extra meta queries here

                          ), WC()->query->get_meta_query() )
                      ) );
                      woocommerce_product_loop_end();
                      ?>

                      <h2 class="products-block__title" id="<?php echo $category->slug;?>" data-link="<?php echo get_term_link( (int) $category->term_id, 'product_cat' ); ?>"><?php echo $category->name; ?></h2>
                      <?php  woocommerce_product_loop_start(); ?>
                      <?php
                          while ( $products_loop->have_posts() ) {
                              $products_loop->the_post();
                              /**
                              * woocommerce_shop_loop hook.
                              *
                              * @hooked WC_Structured_Data::generate_product_data() - 10
                              */
                              do_action( 'woocommerce_shop_loop' );
                              wc_get_template_part( 'content', 'product' );
                          }
                          wp_reset_postdata();
                      endforeach;
                      /* End my loop section */

              }



              /**
              * Hook: woocommerce_after_shop_loop.
              *
              * @hooked woocommerce_pagination - 10
              */
              do_action( 'woocommerce_after_shop_loop' );
          } else {
              /**
              * Hook: woocommerce_no_products_found.
              *
              * @hooked wc_no_products_found - 10
              */
              do_action( 'woocommerce_no_products_found' );
          }

          /**
          * Hook: woocommerce_after_main_content.
          *
          * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
          */
          do_action( 'woocommerce_after_main_content' );

          /**
          * Hook: woocommerce_sidebar.
          *
          * @hooked woocommerce_get_sidebar - 10
          */
          // do_action( 'woocommerce_sidebar' );

          ?>

        </div>
      </div>
    </section>
    <?php get_footer(); ?>
