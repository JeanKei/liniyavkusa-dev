<?php

/* подключаем стили и js */

add_action( 'wp_enqueue_scripts', function(){
  wp_enqueue_style( 'lin-vendor', get_stylesheet_directory_uri() . '/app/css/vendor.css' );
  wp_enqueue_style( 'lin-style', get_stylesheet_directory_uri() . '/app/css/main.css' );
  wp_enqueue_style( 'lin-fonts', get_stylesheet_directory_uri() . '/app/fonts/fonts.css' );

  // wp_enqueue_script( 'jquery' );
  wp_enqueue_script('lin-js', get_template_directory_uri() . '/app/js/main.js', array(), '20151218', true);

});


/* ======= скрыть админ панель  =========*/

add_filter('show_admin_bar', '__return_false');



/* регистрация меню */

register_nav_menus(
	array(
		'head_menu-left' => 'Меню в шапке левое',
	)
);

register_nav_menus(
	array(
		'head_menu-right' => 'Меню в шапке правое',
	)
);

register_nav_menus(
	array(
		'our_menu' => 'Меню',
	)
);


/* woocommerce - подключил подгрузку папки woocommerce из моей темы (не хук) */
add_theme_support( 'woocommerce' );

// Убираем сортировку
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_after_shop_loop' , 'woocommerce_result_count', 20 );

function wpa89819_wc_single_product(){

  $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

  if ( $product_cats && ! is_wp_error ( $product_cats ) ){

      $single_cat = array_shift( $product_cats ); ?>

      <h2 itemprop="name" class="product_category_title"><span><?php echo $single_cat->name; ?></span></h2>

<?php }
}
add_action( 'woocommerce_single_product_summary', 'wpa89819_wc_single_product', 2 );


// хлебные крошки

// function wpcourses_breadcrumb( $sep = ' > ' ) {
// 	global $post;
// 	$out = '';
// 	$out .= '<div class="wpcourses-breadcrumbs">';
// 	$out .= '<a href="' . home_url( '/' ) . '">Главная</a>';
// 	$out .= '<span class="wpcourses-breadcrumbs-sep">' . $sep . '</span>';
// 	if ( is_single() ) {
// 		$terms = get_the_terms( $post, 'category' );
// 		if ( is_array( $terms ) && $terms !== array() ) {
// 			$out .= '<a href="' . get_term_link( $terms[0] ) . '">' . $terms[0]->name . '</a>';
// 			$out .= '<span class="wpcourses-breadcrumbs-sep">' . $sep . '</span>';
// 		}
// 	}
// 	if ( is_singular() ) {
// 		$out .= '<span class="wpcourses-breadcrumbs-last">' . get_the_title() . '</span>';
// 	}
// 	if ( is_search() ) {
// 		$out .= get_search_query();
// 	}
// 	$out .= '</div><!--.wpcourses-breadcrumbs-->';
// 	return $out;
// }



// add_action( 'woocommerce_before_main_content', 'woocommerce_product_category', 100 );


