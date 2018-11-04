<?php
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

/**
 * Submenu class for WP Admin Dashboard.
 * 
 */
class RAFSettingsMenuController extends BaseMenuController
{
	protected $title = 'Settings';
	
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
}