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
    <?php wp_footer(); ?>
  </body>
</html>
