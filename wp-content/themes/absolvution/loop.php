<?php
/**
 * absolvution template for displaying the standard Loop
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */
?>

<article data-price="<?php echo get_post_meta(get_the_ID(), 'item_price', true); ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<h1 class="post-title"><?php

    if ( is_singular() ) :
      the_title();
    else : ?>
      <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php
        the_title(); ?>
      </a><?php
    endif; ?>

  </h1>

  <div class="post-meta"><?php
    absolvution_post_meta(); ?>
  </div>

  <div class="post-content"><?php

    if ( '' != get_the_post_thumbnail() ) : ?>
      <?php the_post_thumbnail(); ?><?php
    endif; ?>

    <?php if ( is_category() || is_archive() || is_search() ) : ?>

      <?php the_excerpt(); ?>
      <!-- Item Price Specification -->
      <div class="price-tag">
      <?php
          echo get_post_meta(get_the_ID(), 'item_price', true);
      ?>
      </div>
      <a
        class="read-more"
        href="<?php the_permalink(); ?>"
      ><?php _e( 'Read more &raquo;', 'absolvution' ); ?></a>

		<?php else : ?>

			<?php the_content( __( 'Continue reading &raquo', 'absolvution' ) ); ?>

		<?php endif; ?>

		<?php
			wp_link_pages(
				array(
					'before'           => '<div class="linked-page-nav"><p>'. __( 'This article has more parts: ', 'absolvution' ),
					'after'            => '</p></div>',
					'next_or_number'   => 'number',
					'separator'        => ' ',
					'pagelink'         => __( '&lt;%&gt;', 'absolvution' ),
				)
			);
		?>

	</div>

</article>
