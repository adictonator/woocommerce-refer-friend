<?php
namespace RAF\Controllers\Menus;

use HelperPlug;
use RAF\Models\RAFSettingsModel;

defined('ABSPATH') or die('Not permitted!');

/**
 *
 */
class RAFSettingsMenuController implements MenuInterface
{
    public $title = 'Settings';
	public $slug = HelperPlug::PLUGIN_SLUG . '-settings';
	public $model;

    protected $cssAssets = [
		'app.css'
    ];

    protected $jsAssets = [
       'app.js'
	];
	
	public function __construct()
	{
		$this->model = new RAFSettingsModel;
	}

    public function menu()
    {
        add_submenu_page(HelperPlug::PLUGIN_SLUG, HelperPlug::PLUGIN_PAGE_TITLE . $this->title, $this->title, 'administrator', $this->slug, [$this, 'menuFunction']);
    }

    public function menuFunction()
    {
        $this->menuView($this);
    }

    public function menuView($menuInstance)
    {
        MenuViewGeneratorController::setView($menuInstance)->getAssets($this->menuAssets());
    }

    public function menuAssets()
    {
        return [
            'css' => $this->cssAssets,
            'js' => $this->jsAssets
        ];
    }
}