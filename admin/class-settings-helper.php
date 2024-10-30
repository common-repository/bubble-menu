<?php

/**
 * Class Settings_Helper
 *
 * This class contains helper methods for retrieving menu item types, share services,
 * and translation options.
 *
 * @package    BubbleMenu
 * @subpackage Admin
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 */

namespace BubbleMenu;

defined( 'ABSPATH' ) || exit;

class Settings_Helper {

	public static function item_type(): array {
		return [
			'link'          => __( 'Link', 'bubble-menu' ),
			'users_start'  => __( 'User Links', 'bubble-menu' ),
			'login'        => __( 'Login', 'bubble-menu' ),
			'logout'       => __( 'Logout', 'bubble-menu' ),
			'lostpassword' => __( 'Lostpassword', 'bubble-menu' ),
			'register'     => __( 'Register', 'bubble-menu' ),
			'users_end'    => __( 'User Links', 'bubble-menu' ),
		];
	}

	public static function label_position(): array {
		return [
			''                        => __( 'Auto', 'bubble-menu' ),
			'-top-right-important'    => __( 'Top Right', 'bubble-menu' ),
			'-top-left-important'     => __( 'Top Left', 'bubble-menu' ),
			'-left-important'         => __( 'Left', 'bubble-menu' ),
			'-right-important'        => __( 'Right', 'bubble-menu' ),
			'-bottom-right-important' => __( 'Bottom Right', 'bubble-menu' ),
			'-bottom-left-important'  => __( 'Bottom Left', 'bubble-menu' ),
		];
	}


}
