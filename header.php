<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
  <meta charset="<?php bloginfo('charset') ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="theme-color" content="#111111">
  <title><?php echo wp_get_document_title() ?></title>
  <?php wp_head(); ?>
</head>
<body>
  <!-- ==================== HEADER  ==================== -->
  <header class="header">
      <!-- === MENU  === -->
      <div class="header__top-content">
      <div class="container">
        <button class="header__btn">
          <span class="header__btn-span"></span>
          <span class="header__btn-span"></span>
          <span class="header__btn-span"></span>
        </button>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <nav class="nav nav--close">
          <button class="rightside-menu__close">
            <span class="rightside-menu__close-span"></span>
            <span class="rightside-menu__close-span"></span>
          </button>
          <div class="nav-wrap">
            <?php
            if (has_nav_menu('head_menu-left')) {
              wp_nav_menu(array(
                'theme_location' => 'head_menu-left',
                'depth' => 1,
                'container' => false,
                'menu_class' => 'menu',
              ));
            }
            ?>
          </div>
          <a href="/">
            <img src="<?php echo get_template_directory_uri() ?>/app/img/logo-white.svg">
          </a>
          <div class="nav-wrap">
            <?php
            if (has_nav_menu('head_menu-right')) {
              wp_nav_menu(array(
                'theme_location' => 'head_menu-right',
                'depth' => 1,
                'container' => false,
                'menu_class' => 'menu',
              ));
            }
            ?>
          </div>
        </nav>
      </div>
    </div>
  </header>
 <!-- shopping cart -->
<?php if (class_exists('woocommerce')) : ?>
	<!-- <a id="top-cart" href="/cart" data-graph-path="lead" > -->
  <a id="top-cart" data-graph-path="lead" >
		<div class="top-cart-icon">
      <div class="top-cart-icon__wrap">
        <svg role="img" style="stroke:#E5D7BE;" class="t706__carticon-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><path fill="none" stroke-width="2" stroke-miterlimit="10" d="M44 18h10v45H10V18h10z"></path><path fill="none" stroke-width="2" stroke-miterlimit="10" d="M22 24V11c0-5.523 4.477-10 10-10s10 4.477 10 10v13"></path></svg>
        <div class="cart-items">
          <div class="count"><?php echo sprintf(_n('%d ', '%d ', WC()->cart->cart_contents_count, 'store'), WC()->cart->cart_contents_count); ?></div>
        </div>
      </div>
		</div>
  </a>
<?php endif; ?>
<!-- shopping cart end -->
