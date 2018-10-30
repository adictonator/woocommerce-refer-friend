<?php 
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

/**
 * 
 */
class DashboardMenusController
{

    public function menuList()
    {
        $getMenus = new CreateMenusController;

        $lol = $getMenus->createMenus();
    }

    public function initMenus()
    {
        add_action('admin_menu', [$this, 'menuList']);
    }

}