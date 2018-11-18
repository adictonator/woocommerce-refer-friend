<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');
	
class RAFSettingsModel extends BaseModel
{
	protected $table = 'raf_settings';

	protected function insert($settingsData)
	{
		$this->dbDriver->insert($this->table, $settingsData);
	}

	protected function get($id)
	{
		return $this->dbDriver->get_row("SELECT * FROM {$this->table}");
	}

	protected function update($id, $settingsData)
	{
		$hasData = $this->get($id);
		
		if (null !== $hasData) :
			$this->dbDriver->update($this->table,
				$settingsData,
				['id' => $id]
			);
		endif;
	}

	public function delete($id)
	{
		//
	}

	public function processSettingsData($settingsData)
	{
		if (!$this->getSettingsData()) :
			$this->insertSettingsData($settingsData);
		else:
			$this->updateSettingsData($settingsData);
		endif;

		if ($this->dbDriver->last_error) :
			$_SESSION['raf']->adminFlash = (object) [
				'type' => 'error',
				'msg' => 'Error: ' . $this->dbDriver->last_error,
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

	public function getSettingsData()
	{
		
	}

	public function getTemplatesData()
	{
		$settingsData = $this->getSettingsData();

		return !empty($settingsData->templatePageIDs) ? unserialize($settingsData->templatePageIDs) : [];
	}

	public function getProductsData()
	{
		$settingsData = $this->getSettingsData();

		return !empty($settingsData->products) ? unserialize($settingsData->products) : [];
	}
	
	public function getDiscountsData()
	{
		$settingsData = $this->getSettingsData();

		return !empty($settingsData->discounts) ? unserialize($settingsData->discounts) : [];
	}
}
