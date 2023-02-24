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
