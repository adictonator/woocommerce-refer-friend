<?php
namespace RAF\Controllers\Menus;

use RAF\Controllers\RAFMembersController;

defined('ABSPATH') or die('Not permitted!');

/**
 * Submenu class for WP Admin Dashboard.
 * 
 */
class RAFMembersMenuController extends BaseMenuController
{
    public $title = 'Members';

    protected $cssAssets = [];

	protected $jsAssets = [];

	public function __construct()
	{
		parent::__construct(['css' => $this->cssAssets, 'js' => $this->jsAssets], 'sub', true);
	}

	// protected function controller()
	// {
	// 	$this->setController(new RAFMembersController);
	// }
}