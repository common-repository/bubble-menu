<?php

use BubbleMenu\Settings_Helper;

defined( 'ABSPATH' ) || exit;

$args = [
	//region Label
	'label' => [
		'type'  => 'text',
		'title' => __( 'Label', 'bubble-menu' ),
	],

	'label_on' => [
		'type'  => 'checkbox',
		'title' => __( 'Label on', 'bubble-menu' ),
		'label' => __( 'Enable', 'bubble-menu' ),
	],

	//endregion

	//region Label
	'type' => [
		'type'  => 'select',
		'title' => __( 'Type', 'bubble-menu' ),
		'value' => 'link',
		'options' => Settings_Helper::item_type(),
	],

	'link' => [
		'type'  => 'text',
		'title' => __( 'Link', 'bubble-menu' ),
	],

	//endregion

	//region Icon
	'icon_type' => [
		'type'    => 'select',
		'title'   => __( 'Icon Type', 'bubble-menu' ),
		'value'   => 'icon',
		'options' => [
			'icon'       => __( 'Icon', 'bubble-menu' ),
		]
	],

	'icon' => [
		'type'    => 'text',
		'title'   => __( 'Icon', 'bubble-menu' ),
		'value'   => 'fas fa-wand-magic-sparkles',
		'options' => [
			'class' => 'wpie-icon-box',
		]
	],

	//endregion

	//region Style
	'color' => [
		'type'    => 'text',
		'value'   => '#ffffff',
		'title'   => __( 'Color', 'bubble-menu' ),
		'options' => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'background_color' => [
		'type'    => 'text',
		'title'   => __( 'Background color', 'bubble-menu' ),
		'value'   => '#14102C',
		'options' => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'label_position' => [
		'type'    => 'select',
		'title'   => __( 'Position', 'bubble-menu' ),
		'options' => Settings_Helper::label_position()
	],

	//endregion

	//region Attributes
	'attribute_id' => [
		'type'    => 'text',
		'title'   => __( 'Attribute ID', 'bubble-menu' ),
	],
	'attribute_class' => [
		'type'    => 'text',
		'title'   => __( 'Attribute Class', 'bubble-menu' ),
	],

	'attribute_rel' => [
		'type'    => 'text',
		'title'   => __( 'Attribute Rel', 'bubble-menu' ),
	],
	//endregion

];

$prefix  = 'item-';
$newArgs = [];

foreach ( $args as $key => $value ) {
	$newArgs[ $prefix . $key ] = $value;
}

return $newArgs;