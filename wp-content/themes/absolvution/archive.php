<?php
/**
 * absolvution template for displaying Archives
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */

get_header(); ?>

	<section class="page-content primary" role="main">

    <?php if ( have_posts() ) : ?>
      <h1 class="archive-title">
        <?php
          if ( is_category() ):
            printf( __( 'Category Archives: %s', 'absolvution' ), single_cat_title( '', false ) );

          elseif ( is_tag() ):
            printf( __( 'List: %s', 'absolvution' ), single_tag_title( '', false ) );

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

      <?php if ( is_tax( 'menu', 'drinks' ) ) { ?>
        <div class="menu"><?php
          $drinks_nav_menu = wp_nav_menu(
            array(
              'container' => 'nav',
              'container_class' => 'drinks-menu',
              'items_wrap' => '<ul class="%2$s">%3$s</ul>',
              'theme_location' => 'drinks-menu',
              'fallback_cb' => '__return_false',
            )
          ); ?>
        </div>
      <?php } ?>

      <?php
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); // get current term
        $parent = get_term($term->parent, get_query_var('taxonomy') ); // get parent term
        $children = get_term_children($term->term_id, get_query_var('taxonomy')); // get children
        if ($parent->slug!='drinks' && (($term->slug=='wine'||$term->slug=='wines') || ($parent->term_id=="") && (sizeof($children)==0))) {
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
        } elseif (($parent->term_id!="") && (sizeof($children)==0)) {
          // has parent, no child
        } elseif (($parent->term_id=="") && (sizeof($children)>0)) {
          // no parent, has child
        }
      ?>

      <?php if ( is_tax( 'menu', 'foods' ) ) { ?>
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

      <?php if ( is_tax( 'menu', 'charcuterie-cheese' ) ) { ?>
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

      while ( have_posts() ) : the_post();

        get_template_part( 'loop', get_post_format() );

      endwhile;

    else :

      get_template_part( 'loop', 'empty' );

    endif; ?>

    <div class="pagination">
      <?php get_template_part( 'template-part', 'pagination' ); ?>
    </div>

  </section>

<?php get_footer(); ?>
