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
      <?php if (has_term('wine', 'menu') || has_term('craft-beers', 'menu')) { ?>
        <?php the_title(); ?>
      <?php } else { ?>
        <a
          href="<?php echo esc_url( get_permalink() ); ?>"
          rel="bookmark"
        >
        <?php the_title(); ?>
        </a>
      <?php } ?>
    <?php endif; ?>

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

      <div class="menu-item-categories">
      <?php
        $product_terms = wp_get_object_terms( get_the_ID(),  'menu' );
        //$termchildren = get_term_children( $term_id->term_id, 'menu' );
        //print_r($termchildren);
        if ( ! empty( $product_terms ) ) {
          if ( ! is_wp_error( $product_terms ) ) {
            echo '<ul>';
              foreach( $product_terms as $term ) {
                $term_id = get_term_by('id', $term->parent, 'menu');
                if ( '' != $term->parent && 'regions' != $term->slug && 'wine' != $term->slug ) {
                  if ( is_tax('menu', $term->slug) ) {
                  } else {
                    echo '<li><a href="' . get_term_link( $term->slug, 'menu' ) . '">' . $term->name . '</a></li>';
                  }
                }
              }
            echo '</ul>';
          }
        }
      ?>
      </div>

      <!--?php
        function custom_posts_per_tag($id, $post_type){
          $args = array(
                'post_type' => array($post_type),
                'posts_per_page' => -1,
                'tag_id' => $id
          );
          $the_query = new WP_Query( $args );
          wp_reset_query();
          return sizeof($the_query->posts);
        }
        $tags = get_tags();
        global $wp_query;
        $post_type = $wp_query->get('post_type');
        foreach ($tags as $tag){
          if (custom_posts_per_tag($tag->term_id, $post_type) > 0) {
            /* Print tag link or whatever you wish here */
          }
        }
      ?-->

      <!-- Item Price Specification -->
      <div class="price-tag">
      <?php
        if (get_post_meta(get_the_ID(), 'item_price', true) == '0') {
      ?>
        <span class="fa fa-plus"></span>
      <?php } else { ?>
      <?php
          echo get_post_meta(get_the_ID(), 'item_price', true);
      ?>
      <?php } ?>
      </div>
      <!--a
        class="read-more"
        href="<?php the_permalink(); ?>"
      ><?php _e( 'Read more &raquo;', 'absolvution' ); ?></a-->

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
