<?php
/**
 * absolvution template for displaying the header
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */
?>

<!DOCTYPE html>

<!--

  (_______) |              | |              (_)(_)(_|_)
   _______| |__   ___  ___ | |_   _ _____    _  _  _ _ ____  _____
  |  ___  |  _ \ /___)/ _ \| | | | | ___ |  | || || | |  _ \| ___ |
  | |   | | |_) )___ | |_| | |\ V /| ____|  | || || | | | | | ____|
  |_|   |_|____/(___/ \___/ \_)\_/ |_____)   \_____/|_|_| |_|_____)

   _
  (_)
   _       ___  _   _ ____   ____ _____
  | |     / _ \| | | |  _ \ / _  | ___ |
  | |____| |_| | |_| | | | ( (_| | ____|
  |_______)___/|____/|_| |_|\___ |_____)
                           (_____|

-->

<!--[if lt IE 7]>      <html class="ie ie-no-support" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
      echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
      echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );

    ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lt IE 9]>
      <script src="<?php echo get_template_directory_uri(); ?>/grunt/bower_components/html5shiv/dist/html5shiv.min.js"></script>
    <![endif]-->
    <link rel="icon"
          type="image/png"
          href="http://absolvewinelounge.com/wp/favicon.png" />
    <?php wp_head(); ?>
    <!--[if (gte IE 6)&(lte IE 8)]>
      <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/grunt/bower_components/selectivizr/selectivizr.js"></script>
      <noscript><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" /></noscript>
    <![endif]-->

  </head>

  <body <?php body_class(); ?>>
    <div class="site ~r-in">

      <header itemscope itemtype="https://schema.org/WPHeader" class="site-header
        <?php if ( '' != get_custom_header()->url ) : ?>
            custom-header
        <?php endif; ?>
        "
        <?php if ( '' != get_custom_header()->url ) : ?>
        style="

          background-image: url(<?php header_image(); ?>);

          <?php if ( '' != get_custom_header()->height ) : ?>
            __height: <?php echo get_custom_header()->height; ?>px;
          <?php endif; ?>

          <?php if ( '' != get_custom_header()->width ) : ?>
            __width: <?php echo get_custom_header()->width; ?>px;
          <?php endif; ?>

        "
        <?php endif; ?>
      >

        <div class="site-banner">
          <a class="logo" href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
            <h1 class="blog-name"><?php bloginfo( 'name' ); ?></h1>
            <!--div class="blog-description"><?php bloginfo( 'description' ); ?></div-->
          </a>

          <div class="menu"><?php
            $main_nav_menu = wp_nav_menu(
              array(
                'container' => 'nav',
                'container_class' => 'main-menu',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'theme_location' => 'main-menu',
                'fallback_cb' => '__return_false',
              )
            ); ?>
          </div>
        </div>

        <div class="site-twop">

          <?php if ( (!is_front_page() || is_singular() || is_search()) && !is_tax('menu') ) : ?>
          <div class="home-widgets home-display-widgets">
            <ul class="inner"><?php
              if ( function_exists( 'dynamic_sidebar' ) ) :
                dynamic_sidebar( 'home-sidebar-display' );
              endif;
            ?></ul>
          </div>
          <?php endif; ?>

          <div class="site-meta">
            <?php get_search_form(); ?>
            <div class="menu"><?php
              $meta_nav_menu = wp_nav_menu(
                array(
                  'container' => 'nav',
                  'container_class' => 'meta-menu',
                  'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                  'theme_location' => 'meta-menu',
                  'fallback_cb' => '__return_false',
                )
              ); ?>
            </div>
          </div>

          <div class="site-caro">
            <?php if(function_exists('chi_display_header')) {
              chi_display_header();
            } ?>

            <div class="menu">
              <!--
                Another Logo Placement
              -->
              <div class="long-logo">
                <div class="inner">
                  <div class="placeholder">
                    <span class="logo"></span>
                  </div>
                </div>
              </div>

              <nav class="caro-menu">
                <ul class="menu">
                  <?php echo absolvution_background_gen(); ?>
                </ul>
              </nav>
            </div>
          </div>

        </div>

      </header>
