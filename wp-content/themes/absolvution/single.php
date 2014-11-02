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
    ?>

        <?php get_template_part( 'loop', get_post_format() ); ?>

        <?php if (is_tax('menu')) { ?>
        <div class="menu-item-price">
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
          $product_terms = wp_get_object_terms( get_the_ID(),  'menu' );
          if ( ! empty( $product_terms ) ) {
            if ( ! is_wp_error( $product_terms ) ) {
              echo '<ul>';
                foreach( $product_terms as $term ) {
                  if ( '' != $term->parent ) {
                    echo '<li><a href="' . get_term_link( $term->slug, 'menu' ) . '">' . $term->name . '</a></li>';
                  }
                }
              echo '</ul>';
            }
          }
        ?>
        </div>

				<aside class="post-aside">

          <div class="post-links">
            <?php if ( is_singular( 'menu_item' ) ) { ?>
              <span class="container">
                <?php previous_post_link( '%link', __( '<span class="fa fa-arrow-left"></span> Previous menu item', 'absolvution' ) ) ?>
              </span>
              <span class="container">
                <?php next_post_link( '%link', __( 'Next menu item <span class="fa fa-arrow-right"></span>', 'absolvution' ) ); ?>
              </span>
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
