<?php 
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

/**
 * 
 */
class CreateMenusController
{
    protected $menus = [
        RAFMenuController::class,
        RAFMembersMenuController::class,
        RAFEmailTemplatesMenuController::class,
        RAFSettingsMenuController::class,
    ];
    public function createMenus()
    {
        foreach ($this->menus as $menu) :
            if (class_exists($menu) && in_array(MenuInterface::class, class_implements($menu))) :
                $menuClass = new $menu;
                $menuClass->menu();
            endif;
        endforeach;
    }
}