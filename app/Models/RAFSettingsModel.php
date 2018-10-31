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
	private $dbDriver = null;
	private $table;

	public function __construct()
	{
		global $wpdb;

		$this->dbDriver = $wpdb;
		$this->table = $this->dbDriver->prefix . 'raf_settings';
	}

	public function processSettingsData($settingsData)
	{
		if (!$this->getSettingsData()) :
			$this->insertSettingsData($settingsData);
		else:
			$this->updateSettingsData($settingsData);
		endif;
	}

	protected function insertSettingsData($settingsData)
	{
		$this->dbDriver->insert($this->table, $settingsData);
	}
	
	protected function updateSettingsData($settingsData)
	{
		$hasData = $this->getSettingsData();
		
		if (null !== $hasData) :
			$this->dbDriver->update($this->table,
				$settingsData,
				['id' => $hasData->id]
			);
		endif;
	}

	public function getSettingsData()
	{
		return $this->dbDriver->get_row("SELECT * FROM {$this->table}");
	}

	public function getTemplatesData()
	{
		$settingsData = $this->getSettingsData();

		return unserialize($settingsData->templatePageIDs);
	}

	public function getProductsData()
	{
		$settingsData = $this->getSettingsData();

		return unserialize($settingsData->products);
	}
	
	public function getDiscountsData()
	{
		$settingsData = $this->getSettingsData();

		return unserialize($settingsData->discounts);
	}
}
