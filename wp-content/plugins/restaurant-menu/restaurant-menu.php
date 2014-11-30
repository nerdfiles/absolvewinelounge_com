<?php
/*
Plugin Name: Restaurant Menu
Plugin URI: http://nerdfiles.net
Author: nerdfiles
Author URI: http://nerdfiles.net
Description: A custom post type that adds menus and custom taxonomies.
Version: 1.0
*/

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

    add_filter( 'manage_edit-menu_item', array( &$this, 'edit_menu_items' ) );

	}

  function edit_menu_items ( $columns ) {
    print_r($columns);
    $columns = array(
      'cb' => '<input type="checkbox" />',
      'title' => __( 'Menu Item' ),
      'item_weight' => __( 'Weight' ),
      'item_price' => __( 'Price' ),
      'date' => __( 'Date' )
    );
    return $columns;
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
      '_builtin' => false,
      'rewrite' => array(
        'slug' => strtolower($this->plural)
      ),
      'capability_type' => 'post',
      'hierarchical' => false,
      'has_archive' => true,
      'menu_position' => 8,
      'taxonomies' => array(),
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

    //register_taxonomy_for_object_type('post_tag', 'menu_item');

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
	  <label for="data[short_desc]">Short Descrption</label>
	  <input type="text" id= "data[short_desc]" name="data[short_desc]" value="<?php echo $short_desc[0] ?>"  placeholder="5-6 Description" size="75" />
	  </p>

		<p>
    <label for="data[item_weight]">Item Weight</label>
    <input
      type="number"
      step="any"
      min="0"
      id= "data[item_weight]"
      name="data[item_weight]"
      value="<?php echo $item_weight[0] ?>"
      placeholder="..."
      size="25" />
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

function add_custom_types_to_tax( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
  // Get all your post types
  //$post_types = get_post_types();
  $post_types = array( 'post', 'menu_item' );
  $query->set( 'post_type', $post_types );
    return $query;
  }
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );

class Tribe_Demo_APM {

	private $post_type = 'menu_item';
	private $textdomain = 'menu-item-apm';

	public function __construct() {
		$this->textdomain = apply_filters( 'tribe_apm_textdomain', $this->textdomain );
		add_action( 'init', array($this, 'test_filters') );
		add_action( 'admin_notices', array($this, 'notice') );
	}

	public function notice() {
		$screen = get_current_screen();
		if ( 'edit-'.$this->post_type !== $screen->id ) {
			return;
		}
		global $wp_query;
		if ( (int) $wp_query->found_posts === 0 ) {
			$path = str_replace(ABSPATH, '', dirname(__FILE__));
			$url = home_url($path) . '/demo_data.xml';
			$import_url = admin_url('import.php');
			echo '<div id="messsage" class="updated"><p>';
			printf( __('It looks like you might not have any demo data. <a href="%s">Download our data</a> and use the <a href="%s">WordPress Importer</a>.', $this->textdomain), $url, $import_url );
			echo '</p></div>';
		}
	}

	public function test_filters() {
		$filter_args = array(
			'tribe_post_status' => array(
				'name' => 'Status',
				'custom_type' => 'post_status',
				'sortable' => true
			)
		);
		$boxes = array(
			'my_box' => 'Filter Box'
		);
		global $cpt_filters;
		$cpt_filters = tribe_setup_apm($this->post_type, $filter_args, $boxes );
		#$cpt_filters->add_taxonomies = false;
	}

	public function log($data = array() ) {
		error_log(print_r($data,1));
	}

}
new Tribe_Demo_APM;

class Tribe_Status_Type {

	protected $key = 'tribe_post_status';
	protected $type = 'post_status';

	public function __construct() {
		$type = $this->type;

		add_filter( 'tribe_custom_column'.$type, array($this, 'column_value'), 10, 3 );
		add_filter( 'tribe_custom_row'.$type, array($this, 'form_row'), 10, 4 );
		add_filter( 'tribe_maybe_active'.$type, array($this, 'maybe_set_active'), 10, 3 );
		add_action( 'tribe_after_parse_query', array($this, 'parse_query'), 10, 2 );
		add_action( 'tribe_orderby_custom'.$type, array($this, 'orderby'), 10, 2 );
	}

	public function orderby($wp_query, $filter) {
		add_filter( 'posts_orderby', array($this, 'set_orderby'), 10, 2 );
	}

	public function set_orderby($orderby, $wp_query) {
		// run once
		remove_filter( 'posts_orderby', array($this, 'set_orderby'), 10, 2 );
		global $wpdb;
		list($by, $order) = explode(' ', trim($orderby) );
		$by = "{$wpdb->posts}.post_status";
		return $by . ' ' . $order;
	}

	public function parse_query($wp_query, $active) {
		if ( ! isset($active[$this->key]) ) {
			return;
		}
		$status = $active[$this->key]['value'];
		$wp_query->set('post_status', $status);
	}

	public function maybe_set_active($return, $key, $filter) {
		if ( isset($_POST[$key]) && ! empty($_POST[$key]) ) {
			return array('value' => $_POST[$key]);
		}
		return $return;
	}

	public function form_row($return, $key, $value, $filter) {
		$stati = get_post_stati(array('show_in_admin_status_list'=>true), 'objects');
		$args = array();
		foreach ( $stati as $k => $object ) {
			$args[$k] = $object->label;
		}
		return tribe_select_field($key, $args, $value['value'], true);
	}

	public function column_value($value, $column_id, $post_id) {
		$status = get_post_status($post_id);
		$status_object = get_post_status_object($status);
		return ( isset($status_object->label) ) ? $status_object->label : $status;
	}

	public function log($data = array() ) {
		error_log(print_r($data,1));
	}


}
new Tribe_Status_Type;



















