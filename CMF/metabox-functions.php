<?php

add_filter( 'cmb_meta_boxes', 'typhoon_metabox' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function typhoon_metabox( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	global $typhoon_slider_prefix; 
	$prefix = $typhoon_slider_prefix;

	$meta_boxes['test_metabox'] = array(
		'id'         => 'bx_slider',
		'title'      => __( 'BX Slider Options', 'cmb' ),
		'pages'      => array( 'typhoon_slider', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name'    => __( 'Mode', 'cmb' ),
				'desc'    => __( 'Type of transition between slides', 'cmb' ),
				'id'      => $prefix . 'mode',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Horizontal', 'cmb' ), 'value' => 'horizontal', ),
					array( 'name' => __( 'Vertical', 'cmb' ), 'value' => 'vertical', ),
					array( 'name' => __( 'Fade', 'cmb' ), 'value' => 'fade', ),
				),
				"default" => "horizontal",
			),
			array(
				'name'    => __( 'Responsive', 'cmb' ),
				'desc'    => __( 'Enable or disable auto resize of the slider. Useful if you need to use fixed width sliders.', 'cmb' ),
				'id'      => $prefix . 'responsive',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "true",
			),
			array(
				'name'    => __( 'Auto', 'cmb' ),
				'desc'    => __( 'Slides will automatically transition.', 'cmb' ),
				'id'      => $prefix . 'auto',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "true",
			),
			array(
				'name'    => __( 'Controls', 'cmb' ),
				'desc'    => __( 'If Enabled, "Next" / "Prev" controls will be added', 'cmb' ),
				'id'      => $prefix . 'controls',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "true",
			),
			array(
				'name' => __( 'Speed', 'cmb' ),
				'desc' => __( 'Slide transition duration (in ms)', 'cmb' ),
				'id'   => $prefix . 'speed',
				'type' => 'text_small',
				// 'repeatable' => true,
				"default" => "500",
			),
			/*array(
				'name' => __( 'Slide Margin', 'cmb' ),
				'desc' => __( 'Margin between each slide', 'cmb' ),
				'id'   => $prefix . 'slideMargin',
				'type' => 'text_small',
				// 'repeatable' => true,
				"default" => "0",
			),*/
			array(
				'name'    => __( 'Random Start', 'cmb' ),
				'desc'    => __( 'Start slider on a random slide.', 'cmb' ),
				'id'      => $prefix . 'randomStart',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),			
			array(
				'name'    => __( 'Infinite Loop', 'cmb' ),
				'desc'    => __( 'If enabled, clicking "Next" while on the last slide will transition to the first slide and vice-versa', 'cmb' ),
				'id'      => $prefix . 'infiniteLoop',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "true",
			),
			array(
				'name'    => __( 'Hide Control On End', 'cmb' ),
				'desc'    => __( 'If true, "Next" control will be hidden on last slide and vice-versa', 'cmb' ),
				'id'      => $prefix . 'hideControlOnEnd',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),			
			array(
				'name'    => __( 'Captions', 'cmb' ),
				'desc'    => __( 'Include image captions. Captions are derived from the image\'s title attribute', 'cmb' ),
				'id'      => $prefix . 'captions',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),
			array(
				'name'    => __( 'Ticker', 'cmb' ),
				'desc'    => __( 'Use slider in ticker mode (similar to a news ticker)', 'cmb' ),
				'id'      => $prefix . 'ticker',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),			
			array(
				'name'    => __( 'adaptiveHeight', 'cmb' ),
				'desc'    => __( 'Dynamically adjust slider height based on each slide\'s height', 'cmb' ),
				'id'      => $prefix . 'adaptiveHeight',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),
			array(
				'name'    => __( 'Video', 'cmb' ),
				'desc'    => __( 'If any slides contain video.', 'cmb' ),
				'id'      => $prefix . 'video',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),		
			array(
				'name'    => __( 'Pager', 'cmb' ),
				'desc'    => __( 'If true, a pager will be added.', 'cmb' ),
				'id'      => $prefix . 'pager',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "true",
			),
			array(
				'name' => __( 'Pause', 'cmb' ),
				'desc' => __( 'The amount of time (in ms) between each auto transition', 'cmb' ),
				'id'   => $prefix . 'pause',
				'type' => 'text_small',
				// 'repeatable' => true,
				"default" => "4000",
			),
			array(
				'name'    => __( 'Auto Direction', 'cmb' ),
				'desc'    => __( 'The direction of auto show slide transitions', 'cmb' ),
				'id'      => $prefix . 'autoDirection',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Next', 'cmb' ), 'value' => 'next', ),
					array( 'name' => __( 'Prev', 'cmb' ), 'prev' => 'false', ),
				),
				"default" => "next",
			),			
			array(
				'name'    => __( 'Auto Hover', 'cmb' ),
				'desc'    => __( 'Auto show will pause when mouse hovers over slider', 'cmb' ),
				'id'      => $prefix . 'autoHover',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Enable', 'cmb' ), 'value' => 'true', ),
					array( 'name' => __( 'Disable', 'cmb' ), 'value' => 'false', ),
				),
				"default" => "false",
			),


		),
	);

	
	return $meta_boxes;
}

add_action( 'init', 'typhoon_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function typhoon_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
