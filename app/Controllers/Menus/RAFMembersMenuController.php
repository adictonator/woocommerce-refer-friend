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
    protected $title = 'Members';

    protected $cssAssets = [];

	protected $jsAssets = [];
	
	public $controller;
	
	public function __construct()
	{
		$this->controller = new RAFMembersController;
		parent::__construct(['css' => $this->cssAssets, 'js' => $this->jsAssets], 'sub', true);
	}
}