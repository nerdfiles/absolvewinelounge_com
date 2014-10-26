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
add_theme_support( 'custom-header', $custom_header_args );

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
add_action( 'wp_head', 'absolvution_custom_header', 11 );

$custom_bg_args = array(
	'default-color' => 'fba919',
	'default-image' => '',
);
add_theme_support( 'custom-background', $custom_bg_args );

register_nav_menu( 'main-menu', __( 'Your sites main menu', 'absolvution' ) );
register_nav_menu( 'meta-menu', __( 'Your sites meta menu', 'absolvution' ) );

if ( function_exists( 'register_sidebars' ) ) {
	register_sidebar(
		array(
			'id' => 'home-sidebar',
			'name' => __( 'Home widgets', 'absolvution' ),
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
			'description' => __( 'Shows in the sites footer', 'absolvution' )
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
define( 'AMD', true );

/**
 * Enqueue absolvution scripts
 * @return void
 */
function absolvution_enqueue_scripts() {
	wp_enqueue_style( 'absolvution-styles', get_stylesheet_uri(), array(), '1.0' );
  // @TODO If local, on-demand!
  if ( AMD == true ) {
    wp_enqueue_script( 'require.js', get_template_directory_uri() . '/grunt/bower_components/requirejs/require.js', array(), '1.0', true );
  } else {
    wp_enqueue_script( 'require.js', get_template_directory_uri() . '/grunt/dist/require.js', array(), '1.0', true );
  }
  wp_enqueue_script( '', 'http://localhost:35729/livereload.js', array(), '0.0.1', true);
  if ( is_singular() ) {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'absolvution_enqueue_scripts' );

/**
 * For On-demand Architecture
 */
add_filter('script_loader_src', 'add_id_to_script', 10, 2);
function add_id_to_script($src, $handle) {
  $theme = 'absolvution';
  $gruntBase = './wp-content/themes/' . $theme . '/grunt';
  $config = $gruntBase . '/app/config';
  if ($handle != 'require.js') {
    return $src;
  }
  if ( AMD == true )
    echo '<script id="requirejs" type="text/javascript" src="' . esc_url( $src ) . '" data-main="' . $config . '"></script>' . PHP_EOL;
  else
    echo '<script id="requirejs" type="text/javascript" src="' . esc_url( $src ) . '"></script>' . PHP_EOL;

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
			__( 'Posted %s in %s%s by %s. ', 'absolvution' ),
			get_the_time( get_option( 'date_format' ) ),
			get_the_category_list( ', ' ),
			get_the_tag_list( __( ', <b>Tags</b>: ', 'absolvution' ), ', ' ),
			get_the_author_link()
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
  <a href="#close">Close</a>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

function add_body_class( $classes )
{
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_body_class' );
