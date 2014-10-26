<?php
/**
 * absolvution template for displaying the Front-Page
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */

get_header(); ?>

  <section
    class="page-content primary"
    role="main"
  >

    <?php

      if ( have_posts() ) : the_post();
        get_template_part( 'loop' );
        //while ( have_posts() ) : the_post();
          //get_template_part( 'loop', get_post_format() );
        //endwhile;
      else :
        //get_template_part( 'loop', 'empty' );
      endif;

    ?>

    <div class="pagination">
      <?php get_template_part( 'template-part', 'pagination' ); ?>
    </div>

  </section>

  <div class="home-widgets">
    <ul class="inner"><?php
      if ( function_exists( 'dynamic_sidebar' ) ) :
        dynamic_sidebar( 'home-sidebar' );
      endif;
    ?></ul>
  </div>

  <div class="home-widgets home-followup-widgets">
    <ul class="inner"><?php
      if ( function_exists( 'dynamic_sidebar' ) ) :
        dynamic_sidebar( 'home-sidebar-followup' );
      endif;
    ?></ul>
  </div>

<?php get_footer(); ?>

