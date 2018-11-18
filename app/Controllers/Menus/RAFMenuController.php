<?php
namespace RAF\Controllers\Menus;

use RAF\Controllers\RAFMembersController;

defined('ABSPATH') or die('Not permitted!');

/**
 * Menu class for WP Admin Dashboard.
 * 
 */
class RAFMenuController extends BaseMenuController
{
    public $title = '';

    protected $cssAssets = [];

    protected $jsAssets = [];

	public function __construct()
	{
		parent::__construct(['css' => $this->cssAssets, 'js' => $this->jsAssets], 'main');
	}

	protected function controller()
	{
		$this->setController(new RAFMembersController);
	}
}