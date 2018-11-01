<?php
namespace RAF\Controllers;

use RAF\Controllers\SettingsController;

defined('ABSPATH') or die('Not permitted!');

/**
 * NEED REWORKING -- hella confused
 */
class RAFRoutesController
{
	private $controllers = [];

	public function __construct()
	{
		$this->controllers = [
			'RAFReferController' => RAFReferController::class,
			'RAFSettingsController' => RAFSettingsController::class,
			'RAFTemplatesController' => RAFTemplatesController::class,
			'RAFEmailTemplatesController' => RAFEmailTemplatesController::class,
		];
	}

	public function listen()
	{
		$controllerStub = $_POST['controller'];
		$controller = $this->resolveController($controllerStub);
		$controllerInstance = new $controller($_POST);
	}

	public function listenAJAX()
	{
		$formData = $_POST['formData'] ?: null;

		if ($formData) {
			parse_str($formData, $formData);

			$controller = $this->resolveController($formData['controller']);
			$controllerInstance = new $controller($_POST);
		}

		wp_die();
	}

	public function resolveController(string $controllerStub)
	{
		$controller = 'RAF' . ucfirst($controllerStub) . 'Controller';
		$controllerInstance = $this->controllers[$controller];

		return $controllerInstance;
	}
}