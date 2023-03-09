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

/* ============================================================================================================  */
/* ==========================================ГЛАНАЯ СТРАНИЦА ==================================================  */
/* ============================================================================================================  */


/* Woocommerce - подключил подгрузку папки woocommerce из моей темы (не хук) */
add_theme_support('woocommerce' );

// Отключил стили WOO!
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// Убираем сортировку
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Убираем сколько всего товаров
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_after_shop_loop' , 'woocommerce_result_count', 20 );


// Выводим 999 товаров

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



/* ============================================================================================================  */
/* ========================================== МИНИ КОРЗИНА ==================================================  */
/* ============================================================================================================  */



// Добавил автообновление в мини корзине + в mini cart - (ВАЖНО!! добавили нужный div с классом widget_shopping_cart_content -

// function mihdan_wc_add_to_cart_message( $message, $product_id ) {
//   return 'Ваш текст';
// }
// add_filter( 'wc_add_to_cart_message', 'mihdan_wc_add_to_cart_message', 10, 2 );


// удаляем кнопку в корзину из МИНИ КОРЗИНЫ
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );


// удаляем кнопку в ОФОРМЛЕНИЯ ЗАКАЗА из МИНИ КОРЗИНЫ
// remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

// Изменили подитог на итоговая сумма
add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');
function translate_text($translated) {
$translated = str_ireplace('Подытог', 'Итоговая сумма', $translated);
return $translated;
}


/* ============================================================================================================  */
/* ========================================== ОФОРМЛЕНИЕ ЗАКАЗА ==================================================  */
/* ============================================================================================================  */



// Скрываем лишние поля
add_filter( 'woocommerce_checkout_fields', 'wpbl_remove_some_fields', 9999 );

  function wpbl_remove_some_fields( $array ) {

    //unset( $array['billing']['billing_first_name'] ); // Имя
    //unset( $array['billing']['billing_phone'] ); // Телефон
    // unset( $array['billing']['billing_address_1'] ); // 1-ая строка адреса
    // unset( $array['billing']['billing_address_2'] ); // 2-ая стро.а адреса
    unset( $array['billing']['billing_last_name'] ); // Фамилия
    unset( $array['order']['order_comments'] ); // Примечание к заказу
    unset( $array['billing']['billing_email'] ); // Email
    unset( $array['billing']['billing_company'] ); // Компания
    unset( $array['billing']['billing_country'] ); // Страна
    unset( $array['billing']['billing_city'] ); // Населённый пункт
    unset( $array['billing']['billing_state'] ); // Область / район
    unset( $array['billing']['billing_postcode'] ); // Почтовый индекс

    // Возвращаем обработанный массив
    return $array;
}


// Приоритет

add_filter( 'woocommerce_checkout_fields', 'wplb_tel_second' );
function wplb_tel_second( $array ) {

    // Меняем приоритет
    $array['billing']['billing_phone']['priority'] = 30;
    // Возвращаем обработанный массив
    return $array;

}

add_filter( 'woocommerce_checkout_fields', 'wplb_my_second1' );
function wplb_my_second1( $array ) {

    // Меняем приоритет
    $array['billing']['billing_address_2']['priority'] = 50;
    // Возвращаем обработанный массив
    return $array;

}

// add_filter( 'woocommerce_checkout_fields', 'wplb_my_second2' );
// function wplb_my_second2( $array ) {

//     // Меняем приоритет
//     $array['billing']['billing_address_2']['priority'] = 40;
//     // Возвращаем обработанный массив
//     return $array;

// }

// удалили label

 // WooCommerce Checkout Fields Hook
//  add_filter( 'woocommerce_checkout_fields' , 'custom_wc_checkout_fields' );

//  // Change the format of fields with type, label, placeholder, class, required, clear, label_class, options
//  function custom_wc_checkout_fields( $fields ) {

//  //BILLING
//  $fields['billing']['billing_first_name']['label'] = false;
//  $fields['billing']['billing_address_1']['label'] = false;
//  $fields['billing']['billing_phone']['label'] = false;
//  $fields['billing']['billing_last_name']['label'] = false;

//  return $fields;
//  }


//================================================= КАСТОМНОЕ ПОЛЕ =======================================

add_filter( 'woocommerce_billing_fields', 'true_add_custom_billing_field', 25 );

function true_add_custom_billing_field( $fields ) {

	// массив нового поля
	$new_field = array(
		'billing_contactmethod' => array(
			'type'          => 'radio', // text, textarea, select, radio, checkbox, password
			'required'	=> true, // по сути только добавляет значок "*" и всё
			'class'         => array( 'true-field', 'form-row-wide' ), // массив классов поля
			'label'         => 'Необходимо ли обслуживание и сервировка? *',
			'label_class'   => 'true-label', // класс лейбла
			'options'	=> array( // options for  or
				'Нет'		=> 'Нет', // пустое значение
				'Да, обслуживание'	=> 'Да, обслуживание', // 'значение'=>'заголовок'
				'Да, сервировка'	=> 'Да, сервировка',
        'Да, обслуживание + сервировка'	=> 'Да, обслуживание + сервировка'
			)
		)
	);

	// объединяем поля
	$fields = array_slice( $fields, 0, 2, true ) + $new_field + array_slice( $fields, 2, NULL, true );

	return $fields;

}

add_action( 'woocommerce_checkout_update_order_meta', 'true_save_field', 25 );

function true_save_field( $order_id ){

	if( ! empty( $_POST[ 'billing_contactmethod' ] ) ) {
		update_post_meta( $order_id, 'billing_contactmethod', sanitize_text_field( $_POST[ 'billing_contactmethod' ] ) );
	}

}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'true_print_field_value', 25 );

function true_print_field_value( $order ) {

	if( $method = get_post_meta( $order->get_id(), 'billing_contactmethod', true ) ) {
		echo '<p><strong>Предпочтительный метод связи:</strong><br>' . esc_html( $method ) . '</p>';
	}
}

add_filter( 'woocommerce_get_order_item_totals', 'truemisha_field_in_email', 25, 2 );

function truemisha_field_in_email( $rows, $order ) {

 	// удалите это условие, если хотите добавить значение поля и на страницу "Заказ принят"
	// if( is_order_received_page() ) {
	// 	return $rows;
	// }

	$rows[ 'billing_contactmethod' ] = array(
		'label' => 'Необходимо ли обслуживание и сервировка?',
		'value' => get_post_meta( $order->get_id(), 'billing_contactmethod', true )
	);

	return $rows;

}

add_filter( 'woocommerce_checkout_fields', 'wplb_my_second' );
function wplb_my_second( $array ) {

    // Меняем приоритет
    $array['billing']['billing_contactmethod']['priority'] = 130;
    // Возвращаем обработанный массив
    return $array;

}
//================================================= КОНЕЦ КАСТОМНОЕ ПОЛЕ =======================================


// удалили label

 add_filter( 'woocommerce_checkout_fields' , 'custom_wc_checkout_fields' );

 function custom_wc_checkout_fields( $fields ) {

 $fields['billing']['billing_first_name']['label'] = false;
 $fields['billing']['billing_address_1']['label'] = false;
 $fields['billing']['billing_phone']['label'] = false;
 $fields['billing']['billing_address_2']['label'] = false;

 return $fields;
 }


// изменили placeholder

add_filter('woocommerce_checkout_fields', 'njengah_override_checkout_fields');

function njengah_override_checkout_fields($fields)

 {

 $fields['billing']['billing_first_name']['placeholder'] = 'Ваше имя';
 $fields['billing']['billing_address_1']['placeholder'] = 'Адрес доставки';
 $fields['billing']['billing_phone']['placeholder'] = 'Введите Ваш номер телефна';
 $fields['billing']['billing_address_2']['placeholder'] = 'Укажите дату и время доставки';
 return $fields;

 }


// Скрываем мини корзину на нужной нам странице

  add_action('wp_head','quadlayers_checkout_style');

  function quadlayers_checkout_style(){
           if(is_checkout()==true){

                   echo '<style> #top-cart .top-cart-icon {
                    display: none;}<style>';
           }
  }





// Купон добавили в самый конец

// remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );


// Изменили название подитог

// add_filter('gettext', 'translate_text');
// add_filter('ngettext', 'translate_text');

// function translate_text($translated) {
// $translated = str_ireplace('Подытог', 'Итоговая сумма', $translated);
// return $translated;
// }

// remove_action('woocommerce_checkout_order_review','woocommerce_checkout_payment', 20 );
//     add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 9 );


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


// add_action( 'template_redirect', 'true_redirect_empty_cart', 25 );

// function true_redirect_empty_cart() {

// 	if(
// 	  is_cart()
// 	  && is_checkout()
// 	  && 0 == WC()->cart->get_cart_contents_count()
// 	  && ! is_wc_endpoint_url( 'order-pay' )
// 	  && ! is_wc_endpoint_url( 'order-received' )
// 	) {

// 		wp_safe_redirect( 'редиректим куда-то' );
// 		exit;
// 	}
// }


// add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
//  function custom_override_checkout_fields( $fields ) {
//    unset($fields['billing']['billing_country']);  //удаляем! тут хранится значение страны оплаты
//    unset($fields['shipping']['shipping_country']); ////удаляем! тут хранится значение страны доставки
//  return $fields;
//  }


