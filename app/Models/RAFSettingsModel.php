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
	private static $dbDriver = null;
	private static $table;

	public function __construct()
	{
		global $wpdb;

		self::$dbDriver = $wpdb;
		self::$table = self::$dbDriver->prefix . 'raf_settings';
	}

	public static function init()
	{
		return new RAFSettingsModel;
	}

	public static function processSettingsData($settingsData)
	{
		if (!self::getSettingsData()) :
			self::insertSettingsData($settingsData);
		else:
			self::updateSettingsData($settingsData);
		endif;

		if (self::$dbDriver->last_error) :
			$_SESSION['raf']->adminFlash = (object) [
				'type' => 'error',
				'msg' => 'Error: ' . self::$dbDriver->last_error,
			];
		else:
			$_SESSION['raf']->adminFlash = (object) [
				'type' => 'success',
				'msg' => 'Settings updated successfully!',
			];
		endif;

		wp_redirect(wp_get_referer());
		exit;
	}

	protected function insertSettingsData($settingsData)
	{
		self::$dbDriver->insert(self::$table, $settingsData);
	}
	
	protected static function updateSettingsData($settingsData)
	{
		$hasData = self::getSettingsData();
		
		if (null !== $hasData) :
			self::$dbDriver->update(self::$table,
				$settingsData,
				['id' => $hasData->id]
			);
		endif;
	}

	public static function getSettingsData()
	{
		return self::$dbDriver->get_row("SELECT * FROM ". self::$table);
	}

	public static function getTemplatesData()
	{
		$settingsData = self::getSettingsData();

		return isset($settingsData->templatePageIDs) ? unserialize($settingsData->templatePageIDs) : [];
	}

	public static function getProductsData()
	{
		$settingsData = self::getSettingsData();

		return isset($settingsData->products) ? unserialize($settingsData->products) : [];
	}
	
	public static function getDiscountsData()
	{
		$settingsData = self::getSettingsData();

		return isset($settingsData->discounts) ? unserialize($settingsData->discounts) : [];
	}
}
