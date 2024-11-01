<?php
/*
Plugin Name: Typhoon Slider
Description: A slider to do it all.
Plugin URI: http://codeholic.in/
Author: promz
Author URI: http://codeholic.in/
Version: 1.0
License: GPL2
*/



$typhoon_slider_prefix = "ts_";

$typhoon_url = plugins_url("" , __FILE__)."/";

$typhoon_name = "typhoon_slider";

$typhoon_slider_defaults = array(
								$typhoon_slider_prefix."accessibility"	=>	"true", 
								$typhoon_slider_prefix."adaptiveHeight"	=>	"false", 
								$typhoon_slider_prefix."autoplay"		=>	"true", 
								$typhoon_slider_prefix."autoplaySpeed"	=>	"3000", 
								$typhoon_slider_prefix."arrows"			=>	"true", 
								$typhoon_slider_prefix."dots"			=>	"false", 
								$typhoon_slider_prefix."draggable"		=>	"true", 
								$typhoon_slider_prefix."fade"			=>	"false", 
								$typhoon_slider_prefix."infinite"		=>	"true", 
								);


require_once "CMF/metabox-functions.php"; 
require_once "content-metabox.php"; 

// Register Custom Post Type
function typhoon_register_post() {

	$labels = array(
		'name'                => _x( 'Sliders', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Slider', 'text_domain' ),
		'name_admin_bar'      => __( 'Post Type', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Slider:', 'text_domain' ),
		'all_items'           => __( 'All Slider', 'text_domain' ),
		'add_new_item'        => __( 'Add New Slider', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Slider', 'text_domain' ),
		'edit_item'           => __( 'Edit Slider', 'text_domain' ),
		'update_item'         => __( 'Update Slider', 'text_domain' ),
		'view_item'           => __( 'View Slider', 'text_domain' ),
		'search_items'        => __( 'Search Slider', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'typhoon_slider', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title',  ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'menu_icon' 		  => 'dashicons-format-gallery',
	);
	register_post_type( 'typhoon_slider', $args );

}

// Hook into the 'init' action
add_action( 'init', 'typhoon_register_post', 0 );

function add_menu_icons_styles(){
	?>
	 
		<style>
			#adminmenu .menu-icon-events div.wp-menu-image:before {
			  content: '\f145';
			}
		</style>
	 
	<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );


function pinkmeadow_scripts() {
	wp_enqueue_style( 'typhoon-slider', plugins_url( 'bxslider/jquery.bxslider.css', __FILE__ ) );
	wp_enqueue_script( 'jquery-ui-core');
	wp_enqueue_script( 'jquery-ui-sortable');
	wp_enqueue_script( 'typhoon-slider', plugins_url(  'bxslider/jquery.bxslider.min.js' , __FILE__), array( 'jquery' ), '1.0.0', true );

}

add_action( 'wp_enqueue_scripts', 'pinkmeadow_scripts' );

add_shortcode(  $typhoon_name, 'typhoon_slider_shortcode' );

function typhoon_slider_shortcode($args){
	
	if(isset($args["id"])) {
		$slider_id = $args["id"];
		$post_content = get_post_content_from_id($slider_id);
		$content = '<div class="typhoon_slider_parent typhoon_slider_'.$slider_id.'">';
		$slides = get_post_meta($slider_id , "slides" , true);
		foreach($slides as $slide) {
			$content .= "<div class='single_slide'>$slide</div>";
		}
		$content .=	'</div>';
		return $content;

	}
}


// ADD NEW COLUMN
function typhoon_slider_columns_head($defaults) {
    $defaults['typhoon_slider_shortcode'] = 'Shortcode';
    return $defaults;
}
 
// SHOW THE SHORTCODE
function typhoon_slider_column_content($column_name, $post_ID) {
    if ($column_name == 'typhoon_slider_shortcode') {
        echo '<code> '.typhoon_get_shortcode($post_ID).'</code>';
    }
}

add_filter('manage_edit-typhoon_slider_columns', 'typhoon_slider_columns_head');
add_action('manage_typhoon_slider_posts_custom_column', 'typhoon_slider_column_content', 10, 2);

function get_post_content_from_id($my_postid) {

	$content_post = get_post($my_postid);
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}



add_action("wp_footer" , "typhoon_slider_footer");

function typhoon_slider_footer() {
?>	
	<script>
	jQuery(document).ready(function(){
	  <?php 

	  	global $typhoon_slider_defaults;
	  	global $typhoon_slider_prefix;
	  	$args = array(
	  					"posts_per_page" => -1,
	  					'post_type' => 'typhoon_slider', 
	  					);
	  	$the_query = new WP_Query( $args );

	  	while($the_query->have_posts()) {
	  		$the_query->the_post();
	  		
	  		$all_meta = get_post_meta( get_the_ID() );
	  		$meta_fixed = array();
	  		foreach($all_meta as $key=>$meta ) {
	  			$meta_fixed[$key] = $meta[0];
	  		}
	  		$args = wp_parse_args( $meta_fixed, $typhoon_slider_defaults );

	  		echo "jQuery('.typhoon_slider_".get_the_ID()."').show(); ";
	  		
			echo "jQuery('.typhoon_slider_".get_the_ID()."').bxSlider({
		
					'mode'				: '{$args[$typhoon_slider_prefix.'mode']}',
					'responsive'		: {$args[$typhoon_slider_prefix.'responsive']},
					'controls'			: {$args[$typhoon_slider_prefix.'controls']},
					'auto'				: {$args[$typhoon_slider_prefix.'auto']},
					'speed'	 			: {$args[$typhoon_slider_prefix.'speed']},	
						
					'randomStart'	 	: {$args[$typhoon_slider_prefix.'randomStart']},	
					'infiniteLoop'	 	: {$args[$typhoon_slider_prefix.'infiniteLoop']},	
					'hideControlOnEnd'	: {$args[$typhoon_slider_prefix.'hideControlOnEnd']},	
					'captions'	 		: {$args[$typhoon_slider_prefix.'captions']},	
					'ticker'	 		: {$args[$typhoon_slider_prefix.'ticker']},	
					'adaptiveHeight'	: {$args[$typhoon_slider_prefix.'adaptiveHeight']},	
					'video'	 			: {$args[$typhoon_slider_prefix.'video']},	
					'pager'	 			: {$args[$typhoon_slider_prefix.'pager']},	
					'pause'	 			: {$args[$typhoon_slider_prefix.'pause']},	
					'autoDirection'	 	: '{$args[$typhoon_slider_prefix.'autoDirection']}',	
					'autoHover'	 		: {$args[$typhoon_slider_prefix.'autoHover']},	
				});"; 

	  	}
	  ?>
	});
	</script>
<?php
}


add_action( 'add_meta_boxes', 'typhoon_add_shortcode_meta_box' );


function typhoon_add_shortcode_meta_box() {
	 global $typhoon_name;
	add_meta_box( "typhoon_shortcode_meta", "Typhoon Shortcode", "typhoon_metabox_shortcode_function", $typhoon_name, "side", 'high' );
}


function typhoon_metabox_shortcode_function($post) {
	
	echo "<code>".typhoon_get_shortcode($post->ID)."</code>";

}

function typhoon_get_shortcode($post_id) {
	global $typhoon_name;

	return "[".$typhoon_name." id=$post_id]";
}

add_action("save_post" , "typhone_save_slides");

function typhone_save_slides($post) {

	$posttype =  get_post_type( $post );
	if($posttype == "typhoon_slider") {
		$slides = $_POST["ts_content"];
		update_post_meta($post , "slides" , $slides);
	}


}

if(!function_exists("pre")) {
	function pre($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}

function typohoon_print_slide($content) {
	global $typhoon_url;
	?>
		<div class="slide_div clearfix">
			<div class="ts_picker">
				<img class='grip' src="<?php echo $typhoon_url."images/grip.png" ?>"> 
				<img class="tycoon_insert_img" src="<?php echo $typhoon_url."images/gallery.png" ?>" > 

			</div>
			<div class="ts_slide_content">
				<textarea class="ts_content" name="ts_content[]"><?php echo $content; ?></textarea>
			</div>
			<div class='tscontrols'> 
				<span class="add"><img src='<?php echo $typhoon_url."images/add.png"?>'></span>
				<span class="remove"><img src='<?php echo $typhoon_url."images/minus.png"?>'></span>
			</div>

		</div>	
	<?php
}


?>