<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
          <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H55RXP6EMR"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H55RXP6EMR');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cambay:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <?php echo get_field( 'zantimes_newsletter_styles', 'option' ); ?>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class();?>>
    <header class="header">
      <div class="header__top">
        <div class="container">
          <div class="header__top-wrapper">
            <div class="d-lg-block d-none">
              <?php if ( pll_current_language() === 'fa' ) : ?>
                <a class="fa-logo" href="<?php echo home_url();?>" aria-label="Go to home page">
                  <img class="custom-logo" alt="zantimes logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/logo-icon.svg" alt="zantimes logo">
                  <span>زن‌تایمز</span>
                </a>
              <?php else : ?>
                <a href="<?php echo home_url();?>" aria-label="Go to home page"><img class="custom-logo" alt="zantimes logo" src="<?php echo get_field( 'zantimes_header_logo', 'option' ); ?>"></a>
              <?php endif; ?>
            </div>
            <ul class="header__top-menu header__top-menu-desktop">
              <?php
                wp_nav_menu(
                  array(
                  'theme_location'  => 'top_menu',
                  'container'       => '',
                  'items_wrap'      => '%3$s',
                  'fallback_cb'     => '__return_false',
                  'walker'          => new WP_bootstrap_4_walker_nav_menu()
                  )
                );
              ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="header__main">
        <div class="container">
          <div class="d-lg-none d-block">
            <?php if ( pll_current_language() === 'fa' ) : ?>
              <a class="fa-logo" href="<?php echo home_url();?>" aria-label="Go to home page">
                <img class="custom-logo" alt="zantimes logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/logo-icon.svg" alt="zantimes logo">
                <span>زن‌تایمز</span>
              </a>
            <?php else : ?>
              <?php if ( get_field( 'zantimes_header_logo', 'option' ) ) : ?>
                <a href="<?php echo home_url();?>" aria-label="Go to home page">
                  <img class="custom-logo" alt="zantimes logo" src="<?php echo get_field( 'zantimes_header_logo', 'option' ); ?>">
                </a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <div class="d-flex align-items-center header-on-mobile">
            <a class="header__toggler d-lg-none d-block js-header__toggler">
              <span class="header__toggler-icon"></span>
              <span class="header__toggler-icon"></span>
              <span class="header__toggler-icon"></span>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="mainmenu">
            <div class="header__search header__search-mobile d-block d-lg-none">
              <form role="search" method="get" id="searchform" class="form searchform js-searchform" action="<?php echo pll_current_language() === 'fa' ? site_url('/fa')  : pll_home_url(pll_current_language()); ?>">
                <div class="search-icon form--searchform__submit js-search-icon">
                  <svg id="Icon_ionic-ios-search" data-name="Icon ionic-ios-search" xmlns="http://www.w3.org/2000/svg" width="27" height="27.007" viewBox="0 0 27 27.007">
                    <path id="Icon_ionic-ios-search-2" data-name="Icon ionic-ios-search" d="M31.184,29.545l-7.509-7.58a10.7,10.7,0,1,0-1.624,1.645l7.46,7.53a1.156,1.156,0,0,0,1.631.042A1.163,1.163,0,0,0,31.184,29.545ZM15.265,23.7a8.45,8.45,0,1,1,5.977-2.475A8.4,8.4,0,0,1,15.265,23.7Z" transform="translate(-4.5 -4.493)" fill="#ffbe06"/>
                  </svg>
                </div>
                <div class="searchform__input">
                  <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="form-control" placeholder="<?php echo __('Search', 'zantimes'); ?>">
                </div>
              </form>
            </div>
            <ul class="header__main-menu">
              <?php
                wp_nav_menu(
                  array(
                  'theme_location'  => 'primary',
                  'container'       => '',
                  'items_wrap'      => '%3$s',
                  'fallback_cb'     => '__return_false',
                  'walker'          => new WP_bootstrap_4_walker_nav_menu()
                  )
                );
              ?>
            </ul>
            <ul class="header__top-menu d-block d-lg-none">
              <?php
                wp_nav_menu(
                  array(
                  'theme_location'  => 'top_menu',
                  'container'       => '',
                  'items_wrap'      => '%3$s',
                  'fallback_cb'     => '__return_false',
                  'walker'          => new WP_bootstrap_4_walker_nav_menu()
                  )
                );
              ?>
            </ul>
            <div class="header__search header__search-desktop d-none d-lg-block">
              <form role="search" method="get" id="searchform" class="form searchform js-searchform" action="<?php echo pll_current_language() === 'fa' ? site_url('/fa')  : pll_home_url(pll_current_language()); ?>">
                <div class="searchform__input">
                  <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="form-control" placeholder="<?php echo __('Search', 'zantimes'); ?>">
                </div>
                <button type="submit" class="search-icon form--searchform__submit js-header-search" aria-label="Search website (mobile view)">
                  <svg id="Icon_ionic-ios-search" data-name="Icon ionic-ios-search" xmlns="http://www.w3.org/2000/svg" width="27" height="27.007" viewBox="0 0 27 27.007">
                    <path id="Icon_ionic-ios-search-2" data-name="Icon ionic-ios-search" d="M31.184,29.545l-7.509-7.58a10.7,10.7,0,1,0-1.624,1.645l7.46,7.53a1.156,1.156,0,0,0,1.631.042A1.163,1.163,0,0,0,31.184,29.545ZM15.265,23.7a8.45,8.45,0,1,1,5.977-2.475A8.4,8.4,0,0,1,15.265,23.7Z" transform="translate(-4.5 -4.493)" fill="#ffbe06"/>
                  </svg>
                  <div class="hidden-search-active"><?php echo __('Search', 'zantimes'); ?> </div>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main class="main">