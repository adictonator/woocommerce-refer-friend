<?php
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

/**
 * Submenu class for WP Admin Dashboard.
 * 
 */
class RAFEmailTemplatesMenuController extends BaseMenuController
{
    protected $title = 'Email Templates';
	
    protected $cssAssets = [];

    protected $jsAssets = [];

	public function __construct()
	{
		parent::__construct(['css' => $this->cssAssets, 'js' => $this->jsAssets]);
	}
}