<?php

/* подключаем стили и js */

// add_action( 'wp_enqueue_scripts', function(){
//   wp_enqueue_style( 'znam-vendor', get_stylesheet_directory_uri() . '/app/css/vendor.css' );
//   wp_enqueue_style( 'znam-style', get_stylesheet_directory_uri() . '/app/css/main.css' );
//   wp_enqueue_style( 'znam-fonts', get_stylesheet_directory_uri() . '/app/fonts/fonts.css' );

//   wp_enqueue_script( 'jquery' );
//   wp_enqueue_script('znam-js', get_template_directory_uri() . '/app/js/main.js', array(), '20151218', true);

// });


/* ======= скрыть админ панель  =========*/

add_filter('show_admin_bar', '__return_false');



/* регистрация меню */

// register_nav_menus(
// 	array(
// 		'head_menu' => 'Меню в шапке',
// 	)
// );

// register_nav_menus(
// 	array(
// 		'head_menu2' => 'Меню в шапке2',
// 	)
// );

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
