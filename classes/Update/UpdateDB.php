<?php

/**
 * Class UpdateDB
 *
 * Contains methods for updating the database structure and data
 *
 * @package    BubbleMenu
 * @subpackage Update
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 *
 */

namespace BubbleMenu\Update;

use BubbleMenu\Admin\DBManager;
use BubbleMenu\Settings_Helper;
use BubbleMenu\WOWP_Plugin;

class UpdateDB {

	const NEW_DB_VERSION = '5.0';
	const TABLE_COLUMNS = "
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title VARCHAR(200) DEFAULT '' NOT NULL,
        param longtext DEFAULT '' NOT NULL,
        status boolean DEFAULT 0 NOT NULL,
        mode boolean DEFAULT 0 NOT NULL,
        tag text DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ";

	public static function init(): void {
		$current_db_version = get_option( WOWP_Plugin::PREFIX . '_db_version' );

		if ( $current_db_version && version_compare( $current_db_version, self::NEW_DB_VERSION, '>=' ) ) {
			return;
		}

		self::start_update();
		update_option( WOWP_Plugin::PREFIX . '_db_version', self::NEW_DB_VERSION );
	}

	private static function start_update(): void {
		self::update_database();
		self::update_fields();
	}

	private static function update_database(): void {
		global $wpdb;

		$table           = $wpdb->prefix . WOWP_Plugin::PREFIX;
		$charset_collate = $wpdb->get_charset_collate();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE $table (" . self::TABLE_COLUMNS . ") $charset_collate;";
		dbDelta( $sql );
	}


	private static function update_fields(): void {
		$results = DBManager::get_all_data();

		if ( empty( $results ) || ! is_array( $results ) ) {
			return;
		}

		foreach ( $results as $result ) {

			$param_updater = new ParamUpdater( maybe_unserialize( $result->param ) );
			$updated_param = $param_updater->update();

			$data = [
				'param'  => maybe_serialize( $updated_param ),
				'status' => absint( ! empty( $updated_param['status'] ) ),
				'mode'   => absint( ! empty( $updated_param['test_mode'] ) ),
				'tag'    => '',
			];

			DBManager::update( $data, [ 'id' => $result->id ], [ '%s', '%d', '%d', '%s' ] );
		}
	}

}