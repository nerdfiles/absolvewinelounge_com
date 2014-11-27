<?php
/**
 * absolvution template for displaying the standard Loop
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */

/* USER-AGENTS
================================================== */
$browser = false;
$mobile = false;
$bot = false;
$user_agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
$type = 'mobile';
if ( $type == 'bot' ) {
  // matches popular bots
  if ( preg_match( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
    $bot = true;
    // watchmouse|pingdom\.com are "uptime services"
  }
} else if ( $type == 'browser' ) {
  // matches core browser types
  if ( preg_match( "/mozilla\/|opera\//", $user_agent ) ) {
    $browser = true;
  }
} else if ( $type == 'mobile' ) {
  // matches popular mobile devices that have small screens and/or touch inputs
  // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
  // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
  if ( preg_match( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
    // these are the most common
    $mobile = true;
  } else if ( preg_match( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
    // these are less common, and might not be worth checking
    $mobile = true;
  }
}

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
      <?php
      //the_post_thumbnail();
      ?><?php
    endif; ?>

    <?php if ( is_category() || is_archive() || is_search() ) : ?>

      <?php the_excerpt(); ?>

      <?php
        $args = array('orderby'=>'term_order', 'order' => 'ASC');
        $product_terms = wp_get_object_terms( get_the_ID(),  'menu', $args);
        //$tags = get_the_term_list();
        /*
         *if ( ! empty( $tags ) ) {
         *  if(get_the_term_list()) {
         *    ?>
         *    <div class="menu-item-tags menu-item-categories">
         *    <?php
         *      $posttags = get_the_terms();
         *      if ($posttags) {
         *        echo '<select class="restrict">';
         *        foreach( $posttags as $tag) {
         *          //$term_id = get_term_by('id', $term->parent, 'menu');
         *          if ( 'regions' != strtolower($tag->name) && 'wine' != strtolower($tag->name) ) {
         *              echo '<option onChange="document.location.href=this.options[this.selectedIndex].value;">' . $tag->name . '</option>';
         *          }
         *        }
         *        echo '</select>';
         *      }
         *    ?>
         *    </div>
         *    <?php
         *  }
         *}
         */
      ?>

      <div class="menu-item-categories">
      <?php
        //$termchildren = get_term_children( $term_id->term_id, 'menu' );
        //print_r($termchildren);
        if ( ! empty( $product_terms ) ) {
          if ( ! is_wp_error( $product_terms ) ) {
              $counter = 0;
              //if (sizeof($product_terms) <= 4 ) {
                echo '<ul>';
                foreach( $product_terms as $term ) {
                  $counter += 1;
                  if ($counter < 6) {
                    $term_id = get_term_by('id', $term->parent, 'menu');
                    if ( '' != $term->parent && 'regions' != $term->slug && 'wine' != $term->slug ) {
                      if ( is_tax('menu', $term->slug) ) {
                      } else {
                        echo '<li>' . $term->name . '</li>';
                      }
                    }
                  }
                }
                $counter = 0;
                echo '</ul>';
              /*
               *} else {
               *  echo '<select class="restrict">';
               *  foreach( $product_terms as $term ) {
               *    $term_id = get_term_by('id', $term->parent, 'menu');
               *    if ( '' != $term->parent && 'regions' != $term->slug && 'wine' != $term->slug ) {
               *      if ( is_tax('menu', $term->slug) ) {
               *      } else {
               *        echo '<option onChange="document.location.href=this.options[this.selectedIndex].value;">' . $term->name . '</option>';
               *      }
               *    }
               *  }
               *  echo '</select>';
               *}
               */
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

      <div class="short-description">
        <p>
        <?php
            echo get_post_meta(get_the_ID(), 'short_desc', true);
        ?>
        </p>
      </div>

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
