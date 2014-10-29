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
register_nav_menu( 'footer-menu', __( 'Your sites footer menu', 'absolvution' ) );

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
			'id' => 'home-sidebar-display',
			'name' => __( 'Home widgets (Display)', 'absolvution' ),
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
define( 'AMD', false );

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
  }
}
add_action( 'wp_enqueue_scripts', 'absolvution_enqueue_scripts' );

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

new MenuItemPostType;		// Initial call

class MenuItemPostType {

  var $single = "Menu Item"; 	// this represents the singular name of the post type
  var $plural = "Items"; 	// this represents the plural name of the post type
  var $type 	= "menu_item"; 	// this is the actual type

	# credit: http://w3prodigy.com/behind-wordpress/php-classes-wordpress-plugin/
	function MenuItemPostType()
	{
		$this->__construct();
	}

	function __construct()
	{
		# Place your add_actions and add_filters here
		add_action( 'init', array( &$this, 'init' ) );
		add_action('init', array(&$this, 'add_post_type'));

		# Add image support
		add_theme_support('post-thumbnails', array( $this->type ) );
		add_image_size(strtolower($this->plural).'-thumb-s', 220, 160, true);
		add_image_size(strtolower($this->plural).'-thumb-m', 300, 180, true);

		# Add Post Type to Search
		add_filter('pre_get_posts', array( &$this, 'query_post_type') );

		# Add Custom Taxonomies
		add_action( 'init', array( &$this, 'add_taxonomies'), 0 );

		# Add meta box
		add_action('add_meta_boxes', array( &$this, 'add_custom_metaboxes') );

		# Save entered data
		add_action('save_post', array( &$this, 'save_postdata') );

	}

	# @credit: http://www.wpinsideout.com/advanced-custom-post-types-php-class-integration
  function init($options = null){
  	if($options) {
	    foreach($options as $key => $value){
	      $this->$key = $value;
	    }
    }
  }

	# @credit: http://www.wpinsideout.com/advanced-custom-post-types-php-class-integration
	function add_post_type(){
    $labels = array(
      'name' => _x($this->plural, 'post type general name'),
      'singular_name' => _x($this->single, 'post type singular name'),
      'add_new' => _x('Add ' . $this->single, $this->single),
      'add_new_item' => __('Add New ' . $this->single),
      'edit_item' => __('Edit ' . $this->single),
      'new_item' => __('New ' . $this->single),
      'view_item' => __('View ' . $this->single),
      'search_items' => __('Search ' . $this->plural),
      'not_found' =>  __('No ' . $this->plural . ' Found'),
      'not_found_in_trash' => __('No ' . $this->plural . ' found in Trash'),
      'parent_item_colon' => ''
    );
    $options = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => array('slug' => strtolower($this->plural)),
      'capability_type' => 'post',
      'hierarchical' => false,
      'has_archive' => true,
      'menu_position' => null,
      'supports' => array(
      	'title',
      	'editor',
#      	'author',
      	'thumbnail',
#      	'excerpt',
      	'comments'
      ),
    );
    register_post_type($this->type, $options);
  }


	function query_post_type($query) {
	  if(is_category() || is_tag()) {
	    $post_type = get_query_var('post_type');
		if($post_type) {
		  $post_type = $post_type;
		} else {
		  $post_type = array($this->type); // replace cpt to your custom post type
	  }
	  $query->set('post_type',$post_type);
		return $query;
	  }
	}

	function add_taxonomies() {
	  register_taxonomy(
	  	'menu',
	  	array($this->type),
	  	array(
		    'hierarchical' => true,
		    'labels' => array(
		    	'name' => __( 'Menu' ),
		    	'singular_name' => __( 'Menus' ),
		    	'all_items' => __( 'All Menus' ),
		    	'add_new_item' => __( 'Add Menu' )
		  	),
		  	'public' => true,
		    'query_var' => true,
		    'rewrite' => array(
		    	'slug' => 'menu'
		    ),
		  )
		 );

	}

	# @credit: http://wptheming.com/2010/08/custom-metabox-for-post-type/
	function add_custom_metaboxes() {
    add_meta_box( 'metabox1', 'Details', array( &$this, 'metabox1'), $this->type, 'normal', 'high' );
	}

	# @credit: http://wptheming.com/2010/08/custom-metabox-for-post-type/
	function metabox1() {

	  global $post;
	  extract(get_post_custom($post->ID));

	  wp_nonce_field( plugin_basename(__FILE__), 'noncename' );  // Use nonce for verification
	?>
		<p>
	  <label for="data[short_title]">Short Title</label>
	  <input type="text" id= "data[short_title]" name="data[short_title]" value="<?php echo $short_title[0] ?>"  placeholder="5-6 Word Title" size="75" />
	  </p>

		<p>
    <label for="data[item_price]">Item Price</label>
	  <input type="number" step="any" min="0" id= "data[item_price]" name="data[item_price]" value="<?php echo $item_price[0] ?>"  placeholder="USD" size="25" />
	  </p>

		<p>
	  <label for="data[menu_item_url]">Menu Item Recipe URL</label>
	  <input type="url" id= "data[menu_item_url]" name="data[menu_item_url]" value="<?php echo $menu_item_url[0] ?>"  placeholder="http://allrecipes.com/recipe/pumpkin-ginger-cupcakes/" size="75" />
	  </p>
	  <style type="text/css">
	  	#metabox1 label {
	  		width: 150px;
	  		display: -moz-inline-stack;
	  		display: inline-block;
	  		zoom: 1;
	  		*display: inline;
	  	}
	  	div.tabs-panel {
	  		height: 80px!important;
	  	}
	  </style>
	<?php
	}


	function save_postdata(){
	  if ( empty($_POST) || $_POST['post_type'] !== $this->type || !wp_verify_nonce( $_POST['noncename'], plugin_basename(__FILE__) )) {
	    return $post_id;
	  }

	  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    	    return $post_id;


	  // Check permissions
	  if ( 'page' == $_POST['post_type'] ) {
	    if ( !current_user_can( 'edit_page', $post_id ) )
	      return $post_id;
	  } else {
	    if ( !current_user_can( 'edit_post', $post_id ) )
	      return $post_id;
	  }

		if($_POST['post_type'] == $this->type) {
			global $post;
			foreach($_POST['data'] as $key => $val) {
				update_post_meta($post->ID, $key, $val);
			}
		}

	}

}

