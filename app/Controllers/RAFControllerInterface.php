<?php
namespace RAF\Controllers;

defined('ABSPATH') or die('Not permitted!');

interface RAFControllerInterface
{
	public function processData(array $data);
	
	public function resolveAction(string $actionStub);

}
