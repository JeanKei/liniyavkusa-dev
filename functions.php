<?php

/* подключаем стили и js */

add_action( 'wp_enqueue_scripts', function(){
  wp_enqueue_style( 'lin-vendor', get_stylesheet_directory_uri() . '/app/css/vendor.css' );
  wp_enqueue_style( 'lin-style', get_stylesheet_directory_uri() . '/app/css/main.css' );
  wp_enqueue_style( 'lin-fonts', get_stylesheet_directory_uri() . '/app/fonts/fonts.css' );

  wp_enqueue_script( 'jquery' );
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
add_theme_support('woocommerce' );

// Убираем сортировку
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Убираем сколько всего товаров
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_after_shop_loop' , 'woocommerce_result_count', 20 );


// Выводим 999 доваров

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 999;' ), 20 );


// Выводим краткое описание

add_action( 'woocommerce_after_shop_loop_item', 'truemisha_short_description', 1 );

function truemisha_short_description() {
	the_excerpt();
}

// Удалил цену
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );


// Добавил цену
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 5 );


add_action( 'woocommerce_init', 'remove_message_after_add_to_cart', 99);

function remove_message_after_add_to_cart(){
    if( isset( $_GET['add-to-cart'] ) ){
        wc_clear_notices();
    }
}


// Изменил надпись просмотр корзины
add_filter( 'woocommerce_get_script_data', 'change_view_cart', 10, 2 );
function change_view_cart( $params, $handle ) {
  if ( $handle == 'wc-add-to-cart' ) {
    $params['i18n_view_cart'] = "Посмотреть"; // Текст
  }
  return $params;
}



// Изменил динамически количество товаров в корзине
add_filter('woocommerce_add_to_cart_fragments', function( $fragments ) {


  $fragments[ '.count' ] = '<div class="count">' . sprintf(_n('%d ', '%d ', WC()->cart->cart_contents_count, 'store'), WC()->cart->cart_contents_count) . '</div>';
  return $fragments;

});


/*убираем кнопку «в корзину» в товарах каталога WooC*/
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );



/*Добавляем свой вариант кнопки в карточку товара*/
add_action('woocommerce_after_shop_loop_item','replace_ats_to_cart');
function replace_ats_to_cart() {
global $product;
$link = $product->get_permalink();
echo do_shortcode('<a href="'.$link.'" class="button addtocartbutton">Подробнее</a>');
}



/* добавили кнопку «в корзину» в товарах каталога WooC*/
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );



// --------------------------------- РАБОТАЕТ -------------------------------
// Добавил автообновление в мини корзине + в mini cart - (ВАЖНО!! добавили нужный div с классом widget_shopping_cart_content -



// function mihdan_wc_add_to_cart_message( $message, $product_id ) {
//   return 'Ваш текст';
// }
// add_filter( 'wc_add_to_cart_message', 'mihdan_wc_add_to_cart_message', 10, 2 );
// --------------------------------- КОНЕЦ РАБОТАЕТ -------------------------------


// add_filter( 'woocommerce_widget_cart_item_quantity', 'add_minicart_quantity_fields', 10, 3 );
// function add_minicart_quantity_fields( $html, $cart_item, $cart_item_key ) {
//     $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $cart_item['data'] ), $cart_item, $cart_item_key );

//     return woocommerce_quantity_input( array('input_value' => $cart_item['quantity']), $cart_item['data'], false ) . $product_price;
// }


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
