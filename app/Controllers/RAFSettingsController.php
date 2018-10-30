<?php
namespace RAF\Controllers;

use RAF\Models\RAFSettingsModel;

defined('ABSPATH') or die('Not permitted!');

/**
 * NEED REWORKING -- not sure if its a best approach
 */
class RAFSettingsController implements RAFControllerInterface
{
	public function __construct(array $data)
	{
		$this->processData($data);
	}

	public function processData(array $data)
	{
		$this->resolveAction($data['rafAction']);
	}

	public function resolveAction(string $actionStub)
	{
		if (method_exists($this, $actionStub)) :
			$this->{$actionStub}();
		endif;
	}

	public function updateSettingsData()
	{
		$products = $data['rafProducts'];
		$tableData = (object)  [
			'products' => (object) $products,
			'templatePageIDs' => (object) [],
		];

		$templatePageIDs = $data['rafTemplateIDs'];

		foreach ($templatePageIDs as $templateName => $templatePageID) :
			$tableData->templatePageIDs = (object) [
				$templatePageID => (object) [
					'name' => $templateName,
					'directory' => $templateName,
				]
			];
		endforeach;

		$settingsModel = new RAFSettingsModel();
		$settingsModel->update($tableData);
	}
}
