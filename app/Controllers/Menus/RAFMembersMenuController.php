<?php
namespace RAF\Controllers\Menus;

use HelperPlug;
use RAF\Models\RAFMembersModel;
use RAF\Controllers\RAFMembersController;

defined('ABSPATH') or die('Not permitted!');

/**
 *
 */
class RAFMembersMenuController implements MenuInterface
{
    public $title = 'Members List';
	public $slug = HelperPlug::PLUGIN_SLUG . '-members';
	public $model;
	public $controller;

    protected $cssAssets = [
    ];

    protected $jsAssets = [
       // 'app.js'
	];
	
	public function __construct()
	{
		$this->model = new RAFMembersModel;
		$this->controller = new RAFMembersController($this->model);
	}

    public function menu()
    {
        add_submenu_page(HelperPlug::PLUGIN_SLUG, HelperPlug::PLUGIN_PAGE_TITLE . $this->title, $this->title, 'administrator', HelperPlug::PLUGIN_SLUG, [$this, 'menuFunction']);
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
            'js' => $this->jsAssets,
        ];
    }
}