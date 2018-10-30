<?php
namespace RAF\Controllers;

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

	public function updateTemplate()
	{
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
	}
}
