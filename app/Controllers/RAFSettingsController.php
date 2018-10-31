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
		$products = $_POST['rafProducts'];	
		$templatePageIDs = $this->prepareTemplatesPageData($_POST);
		$discounts = $this->prepareDiscountData($_POST);
		
		$toUpdateData = [
			'products' => serialize($products),
			'templatePageIDs' => serialize($templatePageIDs),
			'discounts' => serialize($discounts),
		];

		RAFSettingsModel::processSettingsData($toUpdateData);
	}

	public function prepareTemplatesPageData($data)
	{
		$templatePageIDs = $data['rafTemplateIDs'];

		$templatePageData = [];
		foreach ($templatePageIDs as $templateName => $templatePageID) :
			$templatePageData[$templatePageID] = [
				'name' => $templateName,
				'directory' => $templateName,
			];
		endforeach;

		return $templatePageData;
	}

	protected function prepareDiscountData($data)
	{
		$totalReferals = $data['totalReferal'];
		$totalReferalsCount = count($data['totalReferal']);
		$discountAmounts = $data['discountAmount'];
		$freeProds = $data['freeProd'];

		$discounts = [];
		for ($i = 0; $i < $totalReferalsCount; $i++) {
			if (!empty($discountAmounts[$i])) :
				
				$discounts[$totalReferals[$i]] = [
					'discount' => $discountAmounts[$i],
				];

			elseif (!empty($freeProds[$i])) :
				
				$discounts[$totalReferals[$i]] = [
					"freeProd-{$freeProds[$i]}" => $freeProds[$i],
				];

			endif;
		}

		return $discounts;
	}
}
