<?php
/**
 * absolvution template for displaying Archives
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); // get current term
$parent = get_term($term->parent, get_query_var('taxonomy') ); // get parent term
$children = get_term_children($term->term_id, get_query_var('taxonomy')); // get children
$req = $_SERVER['REQUEST_URI'];
get_header();
?>

	<section class="page-content primary" role="main">

    <?php if ( have_posts() ) : ?>
      <h1 class="archive-title">
        <?php
          if ( is_category() ):
            printf( __( 'Category Archives: %s', 'absolvution' ), single_cat_title( '', false ) );

          elseif ( is_tag() ):
            printf( __( 'Tag: %s', 'absolvution' ), single_tag_title( '', false ) );
          elseif ( is_tax() ):
            $term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );
            if (is_tax('menu')) {
              wp_title( '', true, 'right' );
            } else {
              printf( __( '%s Archives: %s', 'absolvution' ), $taxonomy->labels->singular_name, $term->name );
            }
          elseif ( is_day() ) :
            printf( __( 'Daily Archives: %s', 'absolvution' ), get_the_date() );

          elseif ( is_month() ) :
            printf( __( 'Monthly Archives: %s', 'absolvution' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'absolvution' ) ) );

          elseif ( is_year() ) :
            printf( __( 'Yearly Archives: %s', 'absolvution' ), get_the_date( _x( 'Y', 'yearly archives date format', 'absolvution' ) ) );

          elseif ( is_author() ) : the_post();
            printf( __( 'All posts by %s', 'absolvution' ), get_the_author() );

          else :
            _e( 'Archives', 'absolvution' );

          endif;
        ?>
      </h1>

      <?php if ( strpos($req, 'dessert') == false || strpos($req, 'sparkling') == false || strpos($req, 'rose') == false || strpos($req, 'red') == false || strpos($req, 'white') == false || strpos($req, 'wine') == false && ($parent->slug=='drinks' || $parent->slug == 'wine') ) { ?>
        <div class="menu"><?php
          $drinks_nav_menu = wp_nav_menu(
            array(
              'container' => 'nav',
              'container_class' => 'drinks-menu',
              'items_wrap' => '<ul class="%2$s">%3$s</ul>',
              'theme_location' => 'drinks-menu',
              'fallback_cb' => '__return_false',
            )
          );
        ?>
        </div>

      <?php
      }
        if ($term->slug=='wine' && strpos($req, 'drinks')==false) {
        //if ($parent->slug!='wine' && $parent->slug!='foods' && strpos($req, 'drinks') != true && strpos($req, 'menu') == true) {
        ?>
          <div class="menu"><?php
            $wine_nav_menu = wp_nav_menu(
              array(
                'container' => 'nav',
                'container_class' => 'wine-menu',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'theme_location' => 'wine-menu',
                'fallback_cb' => '__return_false',
              )
            ); ?>
          </div>
        <?php
        }
      ?>

      <?php
        if ($parent->slug == 'charcuterie-cheese' || $parent->slug == 'foods') {
      ?>
        <div class="menu"><?php
          $foods_nav_menu = wp_nav_menu(
            array(
              'container' => 'nav',
              'container_class' => 'foods-menu',
              'items_wrap' => '<ul class="%2$s">%3$s</ul>',
              'theme_location' => 'foods-menu',
              'fallback_cb' => '__return_false',
            )
          ); ?>
        </div>
      <?php } ?>

      <!--div class="pagination">
        <?php get_template_part( 'template-part', 'pagination' ); ?>
      </div-->

      <?php if ( is_tax( 'menu', 'charcuterie-cheese' ) || is_tax( 'menu', 'cheese' ) || is_tax( 'menu', 'charcuterie' ) ) { ?>
        <div class="archive-widgets menu-archive-widgets">
          <ul class="inner"><?php
            if ( function_exists( 'dynamic_sidebar' ) ) :
              dynamic_sidebar( 'menu-archive-widgets' );
            endif;
          ?></ul>
        </div>
      <?php } ?>

      <?php if ( is_category() || is_tag() || is_tax() ):
        $term_description = term_description();
        if ( ! empty( $term_description ) ) : ?>

          <div class="archive-description"><?php
            echo $term_description; ?>
          </div><?php

        endif;
      endif;

      if ( is_author() && get_the_author_meta( 'description' ) ) : ?>

        <div class="archive-description">
          <?php the_author_meta( 'description' ); ?>
        </div><?php

      endif;

      if ( strpos($req, 'wine')!=false && (is_dynamic_sidebar('menu-wines-introduction-widgets') ) ) : ?>
        <div class="archive-widgets menu-wines-introduction-widgets">
          <ul class="inner"><?php
            if ( function_exists( 'dynamic_sidebar' ) ) :
              dynamic_sidebar( 'menu-wines-introduction-widgets' );
            endif;
          ?></ul>
        </div><?php
        if (!is_active_sidebar('menu-wines-introduction-widgets') ) :
          while ( have_posts() ) : the_post();
              get_template_part( 'loop', get_post_format() );
          endwhile;
        endif;
      elseif ( strpos($req, 'drinks')!=false && (is_dynamic_sidebar('menu-drinks-introduction-widgets') ) ) : ?>
        <div class="archive-widgets menu-drinks-introduction-widgets">
          <ul class="inner"><?php
            if ( function_exists( 'dynamic_sidebar' ) ) :
              dynamic_sidebar( 'menu-drinks-introduction-widgets' );
            endif;
          ?></ul>
        </div><?php
        if (!is_active_sidebar('menu-drinks-introduction-widgets') ) :
          while ( have_posts() ) : the_post();
              get_template_part( 'loop', get_post_format() );
          endwhile;
        endif;
      elseif ( strpos($req, 'foods')!=false && (is_dynamic_sidebar('menu-foods-introduction-widgets') ) ) : ?>
        <div class="archive-widgets menu-foods-introduction-widgets">
          <ul class="inner"><?php
            if ( function_exists( 'dynamic_sidebar' ) ) :
              dynamic_sidebar( 'menu-foods-introduction-widgets' );
            endif;
          ?></ul>
        </div><?php
        if (!(is_active_sidebar('menu-foods-introduction-widgets')) ) :
          while ( have_posts() ) : the_post();
              get_template_part( 'loop', get_post_format() );
          endwhile;
        endif;
      else:
        while ( have_posts() ) : the_post();
            get_template_part( 'loop', get_post_format() );
        endwhile;
      endif;

    else :

      get_template_part( 'loop', 'empty' );

    endif; ?>

    <div class="pagination">
      <?php
        get_template_part( 'template-part', 'pagination' );
      ?>
    </div>

  </section>

<?php
wp_reset_postdata();
wp_reset_query();
get_footer(); ?>
