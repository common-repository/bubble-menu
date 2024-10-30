<?php

use BubbleMenu\Settings_Helper;

defined( 'ABSPATH' ) || exit;

return [
	//region Label
	'label' => [
		'type'  => 'text',
		'title' => __( 'Label', 'bubble-menu' ),
	],

	'label_on'  => [
		'type'  => 'checkbox',
		'title' => __( 'Label on', 'bubble-menu' ),
		'label' => __( 'Enable', 'bubble-menu' ),
	],

	//endregion

	//region Settings
	'position'  => [
		'type'    => 'select',
		'title'   => __( 'Position', 'bubble-menu' ),
		'value'   => '-left',
		'options' => [
			'-top'          => __( 'Top', 'bubble-menu' ),
			'-top-left'     => __( 'Top Left', 'bubble-menu' ),
			'-top-right'    => __( 'Top Right', 'bubble-menu' ),
			'-right'        => __( 'Right', 'bubble-menu' ),
			'-left'         => __( 'Left', 'bubble-menu' ),
			'-bottom'       => __( 'Bottom', 'bubble-menu' ),
			'-bottom-left'  => __( 'Bottom Left', 'bubble-menu' ),
			'-bottom-right' => __( 'Bottom Right', 'bubble-menu' ),
		],
	],

	//endregion

	//region Icon
	'icon_type' => [
		'type'    => 'select',
		'title'   => __( 'Icon Type', 'bubble-menu' ),
		'value'   => 'icon',
		'options' => [
			'icon' => __( 'Icon', 'bubble-menu' ),
		]
	],

	'icon'   => [
		'type'    => 'text',
		'title'   => __( 'Icon', 'bubble-menu' ),
		'value'   => 'fas fa-wand-magic-sparkles',
		'options' => [
			'class' => 'wpie-icon-box',
		]
	],

	//endregion

	//region Style
	'shapes' => [
		'type'    => 'select',
		'title'   => __( 'Shapes', 'bubble-menu' ),
		'value'   => '-circle',
		'options' => [
			'-circle'  => __( 'Circle', 'bubble-menu' ),
			'-rounded' => __( 'Rounded square', 'bubble-menu' ),
			'-ellipse' => __( 'Ellipse', 'bubble-menu' ),
			'-square'  => __( 'Square', 'bubble-menu' ),
		],
	],

	'animation' => [
		'type'    => 'select',
		'title'   => __( 'Open Animation', 'bubble-menu' ),
		'value'   => '-effect-obo',
		'options' => [
			'-effect-obo' => __( 'One by one', 'bubble-menu' ),
			''            => __( 'All at once', 'bubble-menu' ),
		],
	],

	'size' => [
		'type'    => 'select',
		'title'   => __( 'Size', 'bubble-menu' ),
		'value'   => '-size-md',
		'options' => [
			'-size-xs'  => __( 'Extra Small', 'bubble-menu' ),
			'-size-sm'  => __( 'Small', 'bubble-menu' ),
			'-size-md'  => __( 'Medium', 'bubble-menu' ),
			'-size-lg'  => __( 'Large', 'bubble-menu' ),
			'-size-xl'  => __( 'Extra Large', 'bubble-menu' ),
			'-size-xxl' => __( 'Extra Extra Large', 'bubble-menu' ),
		],
	],

	'shadow' => [
		'type'    => 'select',
		'title'   => __( 'Shadow', 'bubble-menu' ),
		'options' => [
			''            => __( 'Yes', 'bubble-menu' ),
			'-shadowless' => __( 'No', 'bubble-menu' ),
		]
	],


	'color' => [
		'type'    => 'text',
		'value'   => '#14102C',
		'title'   => __( 'Color', 'bubble-menu' ),
		'options' => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'background_color' => [
		'type'    => 'text',
		'title'   => __( 'Background color', 'bubble-menu' ),
		'value'   => '#ffffff',
		'options' => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'label_position'  => [
		'type'    => 'select',
		'title'   => __( 'Position', 'bubble-menu' ),
		'options' => Settings_Helper::label_position()
	],
	//endregion

	//region Attributes
	'attribute_id'    => [
		'type'  => 'text',
		'title' => __( 'Attribute ID', 'bubble-menu' ),
	],
	'attribute_class' => [
		'type'  => 'text',
		'title' => __( 'Attribute Class', 'bubble-menu' ),
	],

	'attribute_rel' => [
		'type'  => 'text',
		'title' => __( 'Attribute Rel', 'bubble-menu' ),
	],
	//endregion
];


