<?php
namespace RAF\Controllers\Menus;

use HelperPlug;

defined('ABSPATH') or die('Not permitted!');

/**
 *
 */
class RAFMenuController implements MenuInterface
{
    protected $title = HelperPlug::PLUGIN_LONG_NAME;
    protected $slug = HelperPlug::PLUGIN_SLUG;

    protected $cssAssets = [
    ];

    protected $jsAssets = [
        //'app.js'
    ];

    public function menu()
    {
        add_menu_page('', $this->title, 'administrator', $this->slug, [$this, 'menuFunction']);
    }

    public function menuFunction()
    {
		/**	Prevent main menu to have its own view */
        //$this->menuView($this->slug);
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