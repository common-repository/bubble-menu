<?php


use BubbleMenu\Settings_Helper;

defined( 'ABSPATH' ) || exit;

$show = [
	'general_start' => __( 'General', 'bubble-menu' ),
	'everywhere'    => __( 'Everywhere', 'bubble-menu' ),
	'shortcode'     => __( 'Shortcode', 'bubble-menu' ),
	'general_end'   => __( 'General', 'bubble-menu' ),

];


$args = [
	//region Display Rules
	'show' => [
		'type'  => 'select',
		'title' => __( 'Display', 'bubble-menu' ),
		'val'   => 'everywhere',
		'atts'  => $show,
	],
	//endregion


	//region Other
	'fontawesome' => [
		'type'  => 'checkbox',
		'title' => __( 'Disable Font Awesome Icon', 'bubble-menu' ),
		'val'   => 0,
		'label' => __( 'Disable', 'bubble-menu' ),
	],
	//endregion

	//region Responsive Visibility
	'mobile'       => [
		'type'  => 'number',
		'title' => [
			'label'  => __( 'Hide on Small Devices', 'bubble-menu' ),
			'name'   => 'mobile_on',
			'toggle' => true,
		],
		'val'   => 480,
		'addon' => 'px',
	],

	'desktop' => [
		'type'  => 'number',
		'title' => [
			'label'  => __( 'Hide on Large Devices', 'bubble-menu' ),
			'name'   => 'desktop_on',
			'toggle' => true,
		],
		'val'   => 1024,
		'addon' => 'px'
	],
	//endregion
];


return $args;
