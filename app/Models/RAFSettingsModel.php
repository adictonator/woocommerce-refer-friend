<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

/**
 * Not really required for Settings page
 * but keeping it here to maintain the 
 * pattern and symentics.
 * 
 */
class RAFSettingsModel
{
	private $tableName = 'raf_settings';

	public function __construct()
	{
		global $wpdb;

		$this->dbDriver = $wpdb;
	}

	public function update($data)
	{
		update_option('rafSettingsData', $data);
		// if (!empty($data)) :
		// 	$this->dbDriver->query(
		// 		$this->dbDriver->prepare(
		// 			"INSERT INTO {$this->dbDriver->prefix}{$this->tableName}
		// 			(templatePage)
		// 			VALUES ( %d )
		// 			",
		// 			8900
		// 		)
		// 	);
		// endif;
	}
}
