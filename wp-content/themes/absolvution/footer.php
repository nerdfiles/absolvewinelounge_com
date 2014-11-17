<?php
/**
 * absolvution template for displaying the footer
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */
?>

        <div
          class="site-footer"
          itemscope
          itemprop="http://schema.org/WPFooter"
        >
          <div class="menu"><?php
            $footer_nav_menu = wp_nav_menu(
              array(
                'container' => 'nav',
                'container_class' => 'footer-menu',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'theme_location' => 'footer-menu',
                'fallback_cb' => '__return_false',
              )
            ); ?>
          </div>

          <ul class="footer-widgets"><?php
            if ( function_exists( 'dynamic_sidebar' ) ) :
              dynamic_sidebar( 'footer-sidebar' );
            endif; ?>
          </ul>
        </div><!-- .site-footer -->

        <div class="foogallery-panel"></div>
      </div><!-- .site -->
    <?php
    $args = array(
        'post_type'      => 'attachment',
        'category_name'  => 'preloader',
        'post_status'    => 'any'
    );

    $preloader_query = new WP_Query ( $args );

    if ( $preloader_query->have_posts() ) :
        ?><style id="ImagePreloader">.preloader { position: absolute; left: -9999px; content:<?php while ( $preloader_query->have_posts() ) : $preloader_query->the_post();
            echo ' url(' . wp_get_attachment_url(get_the_ID()) . ')';
        ?>
        <?php
        endwhile;
        ?>}</style><div class="preloader"></div><?php
    endif;

    wp_reset_postdata();
    ?>
    <?php wp_footer(); ?>
  </body>
</html>
