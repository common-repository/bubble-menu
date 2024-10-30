<?php

defined( 'ABSPATH' ) || exit;

$template = [
	'text' => [
		'type'  => 'text',
		'title' => __( 'Title', 'bubble-menu' ),
		'val'   => '',
		'atts' => [
			'placeholder' => __( 'Placeholder', 'bubble-menu' ),
		],
	],

	'number' => [
		'type'  => 'number',
		'title' => __( 'Title', 'bubble-menu' ),
		'val'   => '',
		'atts' => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	],

	'select' => [
		'type' => 'select',
		'title' => __('Title', 'bubble-menu'),
		'val' => '1',
		'atts' => [
			'1' => __( '1', 'bubble-menu' ),
			'2' => __( '2', 'bubble-menu' ),
			'3' => __( '3', 'bubble-menu' ),
		],
	],

	'color' => [
		'type'  => 'text',
		'val'   => '#ffffff',
		'title' => __( 'Color', 'bubble-menu' ),
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'checkbox' => [
		'type'  => 'checkbox',
		'title' => __( 'Title', 'bubble-menu' ),
		'label' => __( 'Enable', 'bubble-menu' ),
	],

	'title' => [
		'label'  => __( 'Title', 'bubble-menu' ),
		'name'   => '',
		'toggle' => true,
		'val'    => 1
	],

	'addon' => [
		'type' => 'select',
		'name' => '',
		'val'  => '',
		'atts' => [
			'1' => __( '1', 'bubble-menu' ),
			'2' => __( '2', 'bubble-menu' ),
			'3' => __( '3', 'bubble-menu' ),
		],
	],

];