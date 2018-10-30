<?php
namespace RAF\Controllers\Menus;

use HelperPlug;

defined('ABSPATH') or die('Not permitted!');

class RAFEmailTemplatesMenuController implements MenuInterface {
    public $title = 'Email Templates';
    public $slug = HelperPlug::PLUGIN_SLUG . '-email-tps';

    protected $cssAssets = [
    ];

    protected $jsAssets = [
        //'app.js'
    ];

    public function menu()
    {
        add_submenu_page(HelperPlug::PLUGIN_SLUG, HelperPlug::PLUGIN_PAGE_TITLE . $this->title, $this->title, 'administrator', $this->slug, [$this, 'menuFunction']);
    }

    public function menuFunction()
    {
        $this->menuView($this);
    }

    public function menuView($slug)
    {
        MenuViewGeneratorController::setView($slug)->getAssets($this->menuAssets());
    }

    public function menuAssets()
    {
        return [
            'css' => $this->cssAssets,
            'js' => $this->jsAssets
        ];
    }

}