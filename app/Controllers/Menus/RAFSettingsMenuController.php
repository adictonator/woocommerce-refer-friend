<?php
namespace RAF\Controllers\Menus;

use RAF\Controllers\RAFSettingsController;

defined('ABSPATH') or die('Not permitted!');

/**
 * Submenu class for WP Admin Dashboard.
 * 
 */
class RAFSettingsMenuController extends BaseMenuController
{
	public $title = 'Settings';
	
    protected $cssAssets = [
		'app.css'
    ];

    protected $jsAssets = [
       'app.js'
	];

	public function __construct()
	{
		parent::__construct(['css' => $this->cssAssets, 'js' => $this->jsAssets]);
	}

	protected function controller()
	{
		$this->setController(new RAFSettingsController);
	}
}