<?php
/**
 * absolvution functions file
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */

/******************************************************************************\
  Theme support, standard settings, menus and widgets
\******************************************************************************/

add_theme_support( 'post-formats', array( 'image', 'quote', 'status', 'link' ) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );

$custom_header_args = array(
  'width'         => 980,
  'height'        => 300,
  'default-image' => get_template_directory_uri() . '/images/header.png',
);
//add_theme_support( 'custom-header', $custom_header_args );

/**
 * Print custom header styles
 * @return void
 */
function absolvution_custom_header() {
  $styles = '';
  if ( $color = get_header_textcolor() ) {
    echo '<style type="text/css"> ' .
        '.site-header .logo .blog-name, .site-header .logo .blog-description {' .
          'color: #' . $color . ';' .
        '}' .
       '</style>';
  }
}
//add_action( 'wp_head', 'absolvution_custom_header', 11 );

$custom_bg_args = array(
  'default-color' => 'fba919',
  'default-image' => '',
);
//add_theme_support( 'custom-background', $custom_bg_args );

register_nav_menu( 'main-menu', __( 'Your site\'s main menu', 'absolvution' ) );
register_nav_menu( 'meta-menu', __( 'Your site\'s meta menu', 'absolvution' ) );
register_nav_menu( 'footer-menu', __( 'Your site\'s footer menu', 'absolvution' ) );
register_nav_menu( 'drinks-menu', __( 'Your site\'s drinks menu', 'absolvution' ) );
register_nav_menu( 'wine-menu', __( 'Your site\'s wine menu', 'absolvution' ) );
register_nav_menu( 'foods-menu', __( 'Your site\'s foods menu', 'absolvution' ) );

if ( function_exists( 'register_sidebars' ) ) {
  register_sidebar(
    array(
      'id' => 'home-sidebar',
      'name' => __( 'Home widgets (Banner)', 'absolvution' ),
      'description' => __( 'Shows on home page', 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'home-sidebar-display',
      'name' => __( 'Home widgets (Display)', 'absolvution' ),
      'description' => __( 'Shows on home page', 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'home-aside-sidebar',
      'name' => __( 'Home widgets (Aside)', 'absolvution' ),
      'description' => __( 'Shows on home page', 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'home-sidebar-followup',
      'name' => __( 'Home widgets (Followup)', 'absolvution' ),
      'description' => __( 'Shows on home page', 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'footer-sidebar',
      'name' => __( 'Footer widgets', 'absolvution' ),
      'description' => __( "Shows in the site's footer", 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'menu-archive-widgets',
      'name' => __( 'Menu (Submenu) widgets', 'absolvution' ),
      'description' => __( 'Shows on Menu page(s)', 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'menu-wines-introduction-widgets',
      'name' => __( 'Menu Wines Introduction widgets', 'absolvution' ),
      'description' => __( 'Shows on Wines Menu page', 'absolvution' )
    )
  );


  register_sidebar(
    array(
      'id' => 'menu-drinks-introduction-widgets',
      'name' => __( 'Menu Drinks Introduction widgets', 'absolvution' ),
      'description' => __( 'Shows on Drinks Menu page', 'absolvution' )
    )
  );

  register_sidebar(
    array(
      'id' => 'menu-foods-introduction-widgets',
      'name' => __( 'Menu Foods Introduction widgets', 'absolvution' ),
      'description' => __( 'Shows on Foods Menu page', 'absolvution' )
    )
  );

}

if ( ! isset( $content_width ) ) $content_width = 650;

/**
 * Include editor stylesheets
 * @return void
 */
function absolvution_editor_style() {
    add_editor_style( 'css/wp-editor-style.css' );
}
//add_action( 'init', 'absolvution_editor_style' );


/******************************************************************************\
  Scripts and Styles
\******************************************************************************/

/**
 * There are multiple strategies for asynchronous module definition:
 *
 * 1. Source AMD (SAMD) with Static On-demand Resources
 *    Preserves architecture in payload requests for resources, where modules
 *    are unminified with comments.
 * 2. Optimized AMD (OAMD; Recursive R.js) with Static On-demand Resources
 *    Preserves architecture in payload requests for resources, but resources
 *    are minified and potentially obfuscated.
 * 3. Packaged AMD (R.js) - Single Package
 *    Entire application is bundled as one package and marked commit-ish,
 *    where R.js.
 * 4. Route-based; see: https://gist.github.com/ajcrites/7380041,
 *    angularAMD allows mapping of modules to "Module Controllers". Like
 *    event-loading images under responsive @class namespacing, the
 *    application would load JavaScript resources and namespaces based on URI
 *    conditions, which would execute prior to @class-based hooks, as
 *    mentioned above.
 */
define( 'AMD', false );
function wpa54064_inspect_scripts() {
    global $wp_scripts;
    foreach( $wp_scripts->queue as $handle ) :
        echo $handle . ' | ';
    endforeach;
}
//add_action( 'wp_print_scripts', 'wpa54064_inspect_scripts' );
add_action('wp_enqueue_scripts', 'google_maps_config', 25);
function google_maps_config() {

  if (is_page('contact')) {
    /*
     *wp_enqueue_script('google-maps-builder-gmaps');
     *wp_enqueue_script('google-maps-builder-plugin-script');
     *wp_enqueue_script('google-maps-builder-maps-icons');
     */
  } else {

    wp_dequeue_script('google-maps-builder-gmaps');
    wp_dequeue_script('google-maps-builder-plugin-script');
    wp_dequeue_script('google-maps-builder-maps-icons');
    wp_deregister_script('google-maps-builder-gmaps');
    wp_deregister_script('google-maps-builder-plugin-script');
    wp_deregister_script('google-maps-builder-maps-icons');
  }
}
/**
 * Enqueue absolvution scripts
 * @return void
 */
function absolvution_enqueue_scripts() {
  wp_enqueue_style( 'absolvution-styles', get_stylesheet_uri(), array(), '1.0' );

  if ( is_singular() ) {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'comment-reply' );
  }
  // @TODO If local, on-demand!
  /*
   *if ( AMD == true ) {
   *  wp_enqueue_script( 'require.js', get_template_directory_uri() . '/grunt/bower_components/requirejs/require.js', array(), '1.0', true );
   *} else {
   */
  wp_enqueue_script( 'jquery', get_template_directory_uri() . '/grunt/bower_components/jquery/dist/jquery.min.js', array(), '1.0', true );
  wp_enqueue_script( 'main', get_template_directory_uri() . '/grunt/dist/require.js', array('jquery'), '1.0', true );

  /*
   *}
   */
  if (strpos($_SERVER['SERVER_NAME'],'local') !== false) {
    wp_enqueue_script( '', 'http://localhost:35729/livereload.js', array(), '0.0.1', true);
    //echo "<link rel='import' id='Polymer--paper-progress' href='" . get_template_directory_uri() . "/grunt/bower_components/paper-progress/paper-progress.html' />";
  }
}
add_action( 'wp_enqueue_scripts', 'absolvution_enqueue_scripts' );

function login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/grunt/dist/require.js', array('jquery'), '1.0', true );
}
add_action( 'login_enqueue_scripts', 'login_stylesheet' );

/**
 * For On-demand Architecture
 */
//add_filter('script_loader_src', 'add_id_to_script', 10, 2);
function add_id_to_script($src, $handle) {
  $theme = 'absolvution';
  $gruntBase = '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/' . $theme . '/grunt';
  $config = $gruntBase . '/app/config';
  if ($handle != 'require.js') {
    return $src;
  }
  if ( AMD == true )
    echo '<script id="requirejs" type="text/javascript" src="' . esc_url( $src ) . '" data-main="' . $config . '"></script>' . PHP_EOL;
  else
    echo '<script type="text/javascript" src="' . esc_url( $src ) . '"></script>' . PHP_EOL;

  return false;
}

/******************************************************************************\
  Content functions
\******************************************************************************/

/**
 * Displays meta information for a post
 * @return void
 */
function absolvution_post_meta() {
  if ( get_post_type() == 'post' ) {
    echo sprintf(
      __( '<div class="meta-container date-posted">Posted %s </div><div class="meta-container cat"><span class="sep cat"></span> %s </div><div class="meta-container tag "><span class="sep tag"></span> %s </div>', 'absolvution' ),
      get_the_time( get_option( 'date_format' ) ),
      get_the_category_list( ', ' ),
      get_the_tag_list( __( '', 'absolvution' ), ', ' )
    );
  }
  edit_post_link( __( ' (edit)', 'absolvution' ), '<span class="edit-link">', '</span>' );
}

function absolvution_background_gen() {
  $query_images_args = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
    'category_name' => 'carousel'
  );

  $query_images = new WP_Query( $query_images_args );
  $images = array();
  $count = 0;
  foreach ( $query_images->posts as $image) {
      if ($count > 1) {
        $images[]= "";
      } else {
        $images[]= "\n" . '<li class="img-monad img-monad--' . $count . '" style="' . 'background-image: url(' . wp_get_attachment_url( $image->ID ) . ');"><p>' . $image->caption . '</p></li>';
      }
      $count++;
  }
  return implode('', $images);
}

function mytheme_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);

  if ( 'div' == $args['style'] ) {
    $tag = 'div';
    $add_below = 'comment';
  } else {
    $tag = 'li';
    $add_below = 'div-comment';
  }
?>
  <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
  <?php if ( 'div' != $args['style'] ) : ?>
  <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
  <?php endif; ?>
  <div class="comment-author vcard">
  <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
  <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
  </div>
  <?php if ( $comment->comment_approved == '0' ) : ?>
    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
    <br />
  <?php endif; ?>

  <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
    <?php
      /* translators: 1: date, 2: time */
      printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
    ?>
  </div>

  <?php comment_text(); ?>

  <div class="reply">
  <?php
    comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
  ?>
  <a href="#close">
    <span class="label">Close</span>
    <span class="icon"></span>
  </a>
  </div>
  <?php if ( 'div' != $args['style'] ) : ?>
  </div>
  <?php endif; ?>
<?php
}

/**
 * Body Class with Post/Page name
 */
function add_body_class( $classes )
{
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_body_class' );

/**
 * Prevent TinyMCE from stripping out schema.org metadata
 */
function schema_TinyMCE_init($in)
{
    /**
     *   Edit extended_valid_elements as needed. For syntax, see
     *   http://www.tinymce.com/wiki.php/Configuration:valid_elements
     *
     *   NOTE: Adding an element to extended_valid_elements will cause TinyMCE to ignore
     *   default attributes for that element.
     *   Eg. a[title] would remove href unless included in new rule: a[title|href]
     */
    if(!empty($in['extended_valid_elements']))
        $in['extended_valid_elements'] .= ',';

    $in['extended_valid_elements'] .= '@[id|class|style|title|itemscope|itemtype|itemprop|datetime|rel],div,dl,ul,dt,dd,li,span,a|rev|charset|href|lang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur]';

    return $in;
}
add_filter('tiny_mce_before_init', 'schema_TinyMCE_init' );

function thumbnailing($post) {
  global $post;
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
  echo '<div class="background-thumbnail" style="background-image: url(' . $thumb[0] . ');"></div>';
}
add_action('tribe_events_list_widget_before_the_event_title', 'thumbnailing');

add_filter('pre_get_posts','wine_menus_archive');
function wine_menus_archive( $query ) {

    if(is_category() || is_tag()) {
      $post_type = array('nav_menu_item', 'post', 'page', 'attachment');
      $query->set('post_type',$post_type);
    }

    if ( $query->is_tax( 'menu', 'drinks' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'wine', 'by-the-glass', 'craft-beer' )
            )
        ) );
    }

    if ( $query->is_tax( 'menu', 'by-the-glass' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'by-the-glass' )
            )
        ) );
    }

    if ( $query->is_tax( 'menu', 'wine' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        //$terms = get_terms( 'menu', array( 'fields' => 'ids' ) );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'by-the-glass' ),
                'operator' => 'NOT IN'
            ),
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'wine' )
            )
        ) );
    }

    if ( ( $query->is_tax( 'menu', 'white' ) || $query->is_tax( 'menu', 'sparkling' ) || $query->is_tax( 'menu', 'dessert' ) || $query->is_tax( 'menu', 'rose' ) || $query->is_tax( 'menu', 'red' ) ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        //$terms = get_terms( 'menu', array( 'fields' => 'ids' ) );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'by-the-glass' ),
                'operator' => 'NOT IN'
            ),
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'wine' )
            )
        ) );
    }

    if ( $query->is_tax( 'menu', 'craft-beer' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        //$terms = get_terms( 'menu', array( 'fields' => 'ids' ) );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'craft-beer' )
            )
        ) );
    }

    if ( $query->is_tax( 'menu', 'foods' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        //$terms = get_terms( 'menu', array( 'fields' => 'ids' ) );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'charcuterie', 'cheese' ),
                'operator' => 'NOT IN'
            ),
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'small-plates', 'thin-crust-pizzas', 'desserts' )
            )
        ) );
    }

    if ( $query->is_tax( 'menu', 'charcuterie-cheese' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 100 );
        //$terms = get_terms( 'menu', array( 'fields' => 'ids' ) );
        $query->set( 'post_type', array( 'menu_item' ) );
        $query->set( 'tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'menu',
                'field' => 'slug',
                //'terms' => $terms,
                'terms' => array( 'cheese', 'charcuterie' )
            )
        ) );
    }

    return $query;
}

function check_image( $class = '' ) {
  if ( has_post_thumbnail() ) {
    $class[] = 'feature-image';
  } else {
    $class[] = 'no-feature-image';
  }
  global $post;
  if (get_post_meta($post->ID, 'short_desc', true) != '') {
    $class[] = "short-description-enabled";
  } else {
    $class[] = "short-description-disabled";
  }
  return $class;
}
add_filter('post_class', 'check_image');


/**
 * adds meta values on search query
 *
 * @param object $query
 *
 **/
function custom_search_query( $query ) {
  if ( $query->is_search ) {
    $query->set( 'meta_query', array(
      array(
        'key' => '_item_price',
        'value' => $query->query_vars['s'],
        'compare' => 'LIKE'
      )
    ));
  }
  return $query;
}
//add_filter( 'pre_get_posts', 'custom_search_query', 1 );















