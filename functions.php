<?php

// Register Custom Navigation Walker

class wp_bootstrap_navwalker extends Walker_Nav_Menu {
	/**
 * @see Walker::start_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param int $depth Depth of page. Used for padding.
 */
public function start_lvl( &$output, $depth = 0, $args = array() ) {
	$indent = str_repeat( "\t", $depth );
	$output .= "\n$indent<div role=\"menu\" class=\" dropdown-menu\">\n";
}
/**
 * Ends the list of after the elements are added.
 *
 * @see Walker::end_lvl()
 *
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param int    $depth  Depth of menu item. Used for padding.
 * @param array  $args   An array of arguments. @see wp_nav_menu()
 */
public function end_lvl( &$output, $depth = 0, $args = array() ) {
	$indent = str_repeat("\t", $depth);
	$output .= "$indent</div>\n";
}
/**
 * Start the element output.
 *
 * @see Walker::start_el()
 *
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param object $item   Menu item data object.
 * @param int    $depth  Depth of menu item. Used for padding.
 * @param array  $args   An array of arguments. @see wp_nav_menu()
 * @param int    $id     Current item ID.
 */
public function end_el( &$output, $item, $depth = 0, $args = array() ) {
	if($depth === 1){
		if(strcasecmp( $item->attr_title, 'divider' ) == 0 || strcasecmp( $item->title, 'divider') == 0) {
			$output .= '</div>';
		}else if ($depth === 1 && (strcasecmp( $item->attr_title, 'header') == 0 && $depth === 1)) {
			$output .= '</h6>';
		}
	}else{
		$output .= '</li>';
	}
}
/**
 * @see Walker::start_el()
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param object $item Menu item data object.
 * @param int $depth Depth of menu item. Used for padding.
 * @param int $current_page Menu item ID.
 * @param object $args
 */
public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	/**
	 * Dividers, Headers or Disabled
	 * =============================
	 * Determine whether the item is a Divider, Header, Disabled or regular
	 * menu item. To prevent errors we use the strcasecmp() function to so a
	 * comparison that is not case sensitive. The strcasecmp() function returns
	 * a 0 if the strings are equal.
	 */
	//( strcasecmp($item->attr_title, 'disabled' ) == 0 ) 
	
	if($depth === 1 && (strcasecmp( $item->attr_title, 'divider' ) == 0 || strcasecmp( $item->title, 'divider') == 0)) {
		$output .= $indent . '<div class="dropdown-divider">';
	}else if ((strcasecmp( $item->attr_title, 'header') == 0 && $depth === 1) && $depth === 1){
		$output .= $indent . '<h6 class="dropdown-header">' . esc_attr( $item->title );
	}else{
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		$atts = array();
		$atts['title']  = ! empty( $item->title )	? $item->title	: '';
		$atts['target'] = ! empty( $item->target )	? $item->target	: '';
		$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
		$atts['href'] = ! empty( $item->url ) ? $item->url : '';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		
		if ( in_array( 'current-menu-item', $classes ) )
			$classes[] = ' active';
		if($depth === 0){
			$classes[] = 'nav-item';
			$classes[] = 'nav-item-' . $item->ID;
			$atts['class']			= 'nav-link';
			if ( $args->has_children ){
				$classes[] = ' dropdown';
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle nav-link';
				$atts['role']	= 'button';
				$atts['aria-haspopup']	= 'true';
			}
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
		}else{
			$classes[] = 'dropdown-item';
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$atts['class'] = $class_names;
			$atts['id'] = $id;
		}
		
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		
		/*
		 * Icons
		 * ===========
		 * Since the the menu item is NOT a Divider or Header we check the see
		 * if there is a value in the attr_title property. If the attr_title
		 * property is NOT null we apply it as the class name for the icon
		 */
		if ( ! empty( $item->attr_title ) ){
			$item_output .= '<span class="' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
		}
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
/**
 * Traverse elements to create list from elements.
 *
 * Display one element if the element doesn't have any children otherwise,
 * display the element and its children. Will only traverse up to the max
 * depth and no ignore elements under that depth.
 *
 * This method shouldn't be called directly, use the walk() method instead.
 *
 * @see Walker::start_el()
 * @since 2.5.0
 *
 * @param object $element Data object
 * @param array $children_elements List of elements to continue traversing.
 * @param int $max_depth Max depth to traverse.
 * @param int $depth Depth of current element.
 * @param array $args
 * @param string $output Passed by reference. Used to append additional content.
 * @return null Null on failure with no changes to parameters.
 */
public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
	if ( ! $element )
		return;
	$id_field = $this->db_fields['id'];
	// Display this element.
	if ( is_object( $args[0] ) )
		$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
	parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
}
/**
 * Menu Fallback
 * =============
 * If this function is assigned to the wp_nav_menu's fallback_cb variable
 * and a manu has not been assigned to the theme location in the WordPress
 * menu manager the function with display nothing to a non-logged in user,
 * and will add a link to the WordPress menu manager if logged in as an admin.
 *
 * @param array $args passed from the wp_nav_menu function.
 *
 */
public static function fallback( $args ) {
	if ( current_user_can( 'manage_options' ) ) {
		extract( $args );
		$fb_output = null;
		if ( $container ) {
			$fb_output = '<' . $container;
			if ( $container_id )
				$fb_output .= ' id="' . $container_id . '"';
			if ( $container_class )
				$fb_output .= ' class="' . $container_class . '"';
			$fb_output .= '>';
		}
		$fb_output .= '<ul';
		if ( $menu_id )
			$fb_output .= ' id="' . $menu_id . '"';
		if ( $menu_class )
			$fb_output .= ' class="' . $menu_class . '"';
		$fb_output .= '>';
		$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
		$fb_output .= '</ul>';
		if ( $container )
			$fb_output .= '</' . $container . '>';
		echo $fb_output;
	}
}
}
/**
 * Include CSS files
 */
function theme_enqueue_scripts() {
        wp_enqueue_style( 'Font_Awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css' );
        wp_enqueue_style( 'Bootstrap_css', get_template_directory_uri() . '/css/bootstrap.min.css' );
        wp_enqueue_style( 'MDB', get_template_directory_uri() . '/css/mdb.min.css' );
        wp_enqueue_style( 'Style', get_template_directory_uri() . '/style.css' );
        wp_enqueue_script( 'jQuery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array(), '3.3.1', true );
        wp_enqueue_script( 'Tether', get_template_directory_uri() . '/js/popper.min.js', array(), '1.0.0', true );
        wp_enqueue_script( 'Bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0', true );
        wp_enqueue_script( 'MDB', get_template_directory_uri() . '/js/mdb.min.js', array(), '1.0.0', true );

        }
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );


//register theme support
if ( ! function_exists( 'yellow_setup' ) ) :
	
	function yellow_setup() {
		add_theme_support( 'post-thumbnails' );

		register_nav_menus( array(
			'primary' => esc_html__( 'primary', 'yellow' )
		) );
	
	}
endif;
add_action( 'after_setup_theme', 'yellow_setup' );


/**
 * Register our sidebars and widgetized areas.
 */
function yellow_widgets_init() {

	register_sidebar( array(
	  'name'          => 'Sidebar',
	  'id'            => 'sidebar',
	  'before_widget' => '<div class="media-body">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<div class="card-header">',
	  'after_title'   => '</div>',
	));
	register_sidebar( array(
		'name'          => 'Footer',
		'id'            => 'footer',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	  ));
	
  
  }
  add_action( 'widgets_init', 'yellow_widgets_init' );


//register posttype video

add_action('init', 'video_custom_post_type');
function video_custom_post_type(){

	register_post_type('video', array(
		'labels'             => array(
			'name'               => 'video', 
			'singular_name'      => 'Video', 
			'add_new'            => 'Add new',
			'add_new_item'       => 'Add new video',
			'edit_item'          => 'Edit video',
			'new_item'           => 'New video',
			'view_item'          => 'View video',
			'search_items'       => 'Search video',
			'not_found'          =>  'slides not found',
			'not_found_in_trash' => 'not found video in trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Video'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => 'video',
		'hierarchical'       => false,
		'menu_position'      => null,
        'menu_icon'          => 'dashicons-welcome-add-page',
		'supports'           => array('title','editor','thumbnail','excerpt')
	
		) );

}





//register meta box
add_action('add_meta_boxes', 'myplugin_add_custom_box');
function myplugin_add_custom_box(){
	$screens = 'video';
	add_meta_box( 'myplugin_sectionid', 'video_meta_box', 'myplugin_meta_box_callback', $screens );
}


function myplugin_meta_box_callback( $post, $meta ){
	$screens = $meta['args'];

	wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

	$value = get_post_meta( $post->ID, 'ganre', 1 );
	$value2 = get_post_meta( $post->ID, 'order', 1 );

	echo '<label for="ganre_field">' . __("Video ganre", 'myplugin_textdomain' ) . '</label> ';
	echo '<input type="text" id="ganre_field" name="ganre_field" value="'. $value .'" size="25" />';
	echo '</br>';
	echo '<label for="order_field">' . __("Order", 'myplugin_textdomain' ) . '</label> ';
	echo '<input type="text" id="order_field" name="order_field" value="'. $value2 .'" size="25" />';

	
}


add_action( 'save_post', 'myplugin_save_postdata' );
function myplugin_save_postdata( $post_id ) {

	if ( ! isset( $_POST['ganre_field'] ) )
		return;
		if ( ! isset( $_POST['order_field'] ) )
		return;


	
	if ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
		return;


	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return;


	if( ! current_user_can( 'edit_post', $post_id ) )
		return;


	$my_data = sanitize_text_field( $_POST['ganre_field'] );
	$my_data2 = sanitize_text_field( $_POST['order_field'] );

	update_post_meta( $post_id, 'ganre', $my_data );
	update_post_meta( $post_id, 'order', $my_data2 );
}

//class for sorting custom post type video

  class Cpt_sort extends WP_Query {

	public function __construct() {
		$args2 = array(
			'post_type' => 'video',
			'meta_key' => 'order',
			'orderby' => 'meta_value_num',
			'order' => 'ASC'
		  );
		  $query2 = new WP_Query($args2);

		  while ( $query2->have_posts() ) {
			$query2->the_post(); ?>
			
			<div class="col-lg-4 col-md-12 mb-4">
		
			<div class="view overlay hm-white-slight rounded z-depth-2 mb-4">
			<?php the_post_thumbnail( 'medium-large', array( 'class'=> 'img-fluid')); ?>
				<a href="<?php the_permalink(); ?>">
					<div class="mask"></div>
				</a>
			</div>

		
			<a href="<?php echo  get_permalink();?>" class="pink-text">
				<h6 class="mb-3 mt-4">
					<i class="fa fa-bolt"></i>
					<strong><?php the_category(', '); ?></strong>
				</h6>
			</a>
			<h4 class="mb-3 font-weight-bold dark-grey-text">
				<strong><?php	echo get_the_title(); ?></strong>
			</h4>
			<p>by
				<a class="font-weight-bold dark-grey-text"><?php echo get_the_author(); ?></a><?php echo get_the_date(); ?></p>
		  
			<a href="<?php echo get_permalink() ?>"class="btn btn-info btn-rounded btn-md">Read more</a>
		</div>

		
<?php
}
	}
	}


	add_filter( 'excerpt_length', function(){
		return 20;
	} );

	add_image_size( 'small_thumb', 80, 60, true );
	

//customier


function yellow_customizer_settings( $wp_customize ) {
	//background color
	$wp_customize->add_section( 'cd_colors' , array(
		'title'      => 'Colors',
		'priority'   => 30,
	) );

	$wp_customize->add_setting( 'background_color' , array(
		'default'     => '#43C6E4',
		'transport'   => 'refresh',
	) );

	
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
	'label'        => 'Background Color',
	'section'    => 'cd_colors',
	'settings'   => 'background_color',
) ) );

//logo

$wp_customize->add_section( 'logo' , array(
	'title'      => 'Logo',
	'priority'   => 20,
) );
$wp_customize->add_setting( 'sample_default_image',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'esc_url_raw'
   )
);
 
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sample_default_image',
   array(
      'label' => __( 'Default Image Control' ),
      'description' => esc_html__( 'This is the description for the Image Control' ),
	  'section'    => 'logo',
      'button_labels' => array( 
         'select' => __( 'Select Image' ),
         'change' => __( 'Change Image' ),
         'remove' => __( 'Remove' ),
         'default' => __( 'Default' ),
         'placeholder' => __( 'No image selected' ),
         'frame_title' => __( 'Select Image' ),
         'frame_button' => __( 'Choose Image' ),
      )
   )
) );
//slider
$wp_customize->add_section( 'slider' , array(
	'title'      => 'Slider',
	'priority'   => 40,
) );
//slide1
$wp_customize->add_setting( 'slide1_image',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'esc_url_raw'
   )
);
 
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide1_image',
   array(
      'label' => __( 'slide1 image' ),
      'description' => esc_html__( '' ),
	  'section'    => 'slider',
      'button_labels' => array( 
         'select' => __( 'Select Image' ),
         'change' => __( 'Change Image' ),
         'remove' => __( 'Remove' ),
         'default' => __( 'Default' ),
         'placeholder' => __( 'No image selected' ),
         'frame_title' => __( 'Select Image' ),
         'frame_button' => __( 'Choose Image' ),
      )
   )
) );

$wp_customize->add_setting( 'slide1_header',
   array(
	'default'            => '',
	'sanitize_callback'  => 'sanitize_text_field',
	'transport'          => $transport
   )
);
 
$wp_customize->add_control( 'slide1_header',
   array(
	'section'  => 'slider', 
	'label'    => 'Slide1 header',
	'type'     => 'text' 
   )
);


$wp_customize->add_setting( 'slide1_text',
   array(
	'default'            => '',
	'sanitize_callback'  => 'sanitize_text_field',
	'transport'          => $transport
     
   )
);
 
$wp_customize->add_control( 'slide1_text',
   array(
	'section'  => 'slider', 
	'label'    => 'Slide1 text',
	'type'     => 'text' 

   )
);

//slide2

$wp_customize->add_setting( 'slide2_image',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'esc_url_raw'
   )
);
 
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide2_image',
   array(
      'label' => __( 'slide2 image' ),
      'description' => esc_html__( '' ),
	  'section'    => 'slider',
      'button_labels' => array( 
         'select' => __( 'Select Image' ),
         'change' => __( 'Change Image' ),
         'remove' => __( 'Remove' ),
         'default' => __( 'Default' ),
         'placeholder' => __( 'No image selected' ),
         'frame_title' => __( 'Select Image' ),
         'frame_button' => __( 'Choose Image' ),
      )
   )
) );

$wp_customize->add_setting( 'slide2_header',
   array(
	'default'            => '',
	'sanitize_callback'  => 'sanitize_text_field',
	'transport'          => $transport
   )
);
 
$wp_customize->add_control( 'slide2_header',
   array(
	'section'  => 'slider', 
	'label'    => 'Slide2 header',
	'type'     => 'text' 
   )
);


$wp_customize->add_setting( 'slide2_text',
   array(
	'default'            => '',
	'sanitize_callback'  => 'sanitize_text_field',
	'transport'          => $transport
     
   )
);
 
$wp_customize->add_control( 'slide2_text',
   array(
	'section'  => 'slider', 
	'label'    => 'Slide2 text',
	'type'     => 'text' 

   )
);
//slide3

$wp_customize->add_setting( 'slide3_image',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'esc_url_raw'
   )
);
 
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide3_image',
   array(
      'label' => __( 'slide3 image' ),
      'description' => esc_html__( '' ),
	  'section'    => 'slider',
      'button_labels' => array( 
         'select' => __( 'Select Image' ),
         'change' => __( 'Change Image' ),
         'remove' => __( 'Remove' ),
         'default' => __( 'Default' ),
         'placeholder' => __( 'No image selected' ),
         'frame_title' => __( 'Select Image' ),
         'frame_button' => __( 'Choose Image' ),
      )
   )
) );

$wp_customize->add_setting( 'slide3_header',
   array(
	'default'            => '',
	'sanitize_callback'  => 'sanitize_text_field',
	'transport'          => $transport
   )
);
 
$wp_customize->add_control( 'slide3_header',
   array(
	'section'  => 'slider', 
	'label'    => 'Slide3 header',
	'type'     => 'text' 
   )
);


$wp_customize->add_setting( 'slide3_text',
   array(
	'default'            => '',
	'sanitize_callback'  => 'sanitize_text_field',
	'transport'          => $transport
     
   )
);
 
$wp_customize->add_control( 'slide3_text',
   array(
	'section'  => 'slider', 
	'label'    => 'Slide3 text',
	'type'     => 'text' 

   )
);
}
add_action( 'customize_register', 'yellow_customizer_settings' );


add_action( 'wp_head', 'ylw_customizer_css');
function ylw_customizer_css()
{
    ?>
         <style type="text/css">
             body { background: #<?php echo get_theme_mod('background_color', '#43C6E4'); ?>; }
         </style>
    <?php
}

	