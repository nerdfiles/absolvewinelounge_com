<?php
/**
 * absolvution template for displaying Single-Posts
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */
get_header(); ?>

  <section class="page-content primary" role="main">

    <?php
      if ( have_posts() ) : the_post();
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
    ?>

        <img style="position: absolute; left: -9999px;" src="<?php echo $feat_image; ?>" />

        <?php get_template_part( 'loop', get_post_format() ); ?>

        <div class="short-description">
          <p>
          <?php
              echo get_post_meta(get_the_ID(), 'short_desc', true);
          ?>
          </p>
        </div>

        <?php
          $product_terms = wp_get_object_terms( get_the_ID(),  'menu' );
          if ( ! empty( $product_terms ) ) {
        ?>
          <div class="menu-item-price menu-item-price-type-<?php
                echo get_post_meta(get_the_ID(), 'item_price', true);
            ?>">
            <span class="label">Price</span>
            <span class="value">
            <?php
                echo get_post_meta(get_the_ID(), 'item_price', true);
            ?>
            </span>
          </div>
        <?php } ?>

        <div class="menu-item-categories">
        <?php

          /*
           *$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); // get current term
           *$parent = get_term($term->parent, get_query_var('taxonomy') ); // get parent term
           *$children = get_term_children($term->term_id, get_query_var('taxonomy')); // get children
           *if(($parent->term_id!="" && sizeof($children)>0)) {
           *  // has parent and child
           *}elseif(($parent->term_id!="") && (sizeof($children)==0)) {
           *  // has parent, no child
           *}elseif(($parent->term_id=="") && (sizeof($children)>0)) {
           *  // no parent, has child
           *}
           */

            if ( ! empty( $product_terms ) ) {
              if ( ! is_wp_error( $product_terms ) ) {
                echo '<ul>';
                  foreach( $product_terms as $term ) {
                    //$children = get_term_children($term->term_id, get_query_var('taxonomy'));
                    $parent = get_term($term->parent, 'menu');
                    // &&$parent!='wine')
                    if (($term->slug!="wine"&&$term->slug!="foods"&&$term->slug!="drinks")) {
                      echo '<li><a href="' . get_term_link( $term->slug, 'menu' ) . '">' . $term->name . '</a></li>';
                    }
                  }
                echo '</ul>';
              }
            }
        ?>
        </div>
        <?php
          /*
           *}
           */
        ?>

        <aside class="post-aside">

          <div class="post-links">
            <?php if ( is_singular( 'menu_item' ) ) { ?>
              <?php
              /**
              * Infinite next and previous post looping in WordPress
              */
              if( get_adjacent_post(false, '', true) ) {
                echo '<span class="container">';
                previous_post_link('%link', '<span class="fa fa-arrow-left"></span> Previous menu item');
                echo '</span>';
              } else {
                $first = new WP_Query('posts_per_page=1&post_type=menu_item&order=DESC'); $first->the_post();
                echo '<span class="container"><a href="' . get_permalink() . '"><span class="fa fa-arrow-left"></span> Previous menu item</a></span>';
                wp_reset_query();
              };
              if( get_adjacent_post(false, '', false) ) {
                echo '<span class="container">';
                next_post_link('%link', 'Next menu item <span class="fa fa-arrow-right"></span>');
                echo '</span>';
              } else {
                $last = new WP_Query('posts_per_page=1&post_type=menu_item&order=ASC'); $last->the_post();
                echo '<span class="container"><a href="' . get_permalink() . '">Next menu item <span class="fa fa-arrow-right"></span></a></span>';
                wp_reset_query();
              };
              ?>
              <!--span class="container">
                <?php previous_post_link( '%link', __( '<span class="fa fa-arrow-left"></span> Previous menu item', 'absolvution' ) ) ?>
              </span>
              <span class="container">
                <?php next_post_link( '%link', __( 'Next menu item <span class="fa fa-arrow-right"></span>', 'absolvution' ) ); ?>
              </span-->
            <?php } else { ?>
              <span class="container">
                <?php previous_post_link( '%link', __( '<span class="fa fa-arrow-left"></span> Previous post', 'absolvution' ) ) ?>
              </span>
              <span class="container">
                <?php next_post_link( '%link', __( 'Next post <span class="fa fa-arrow-right"></span>', 'absolvution' ) ); ?>
              </span>
            <?php } ?>
          </div>

          <?php
            if ( comments_open() || get_comments_number() > 0 ) :
              comments_template( '', true );
            endif;
          ?>

        </aside><?php

      else :

        get_template_part( 'loop', 'empty' );

      endif;
    ?>

  </section>

<?php get_footer(); ?>
