<?php
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

/**
 * Activates registered WP Menus and Submenus.
 * 
 * @package RAF
 * @author Adictonator <adityabhaskarsharma@gmail.com>
 * @since 1.0
 */
class AdminMenusController extends Menus
{
	/**
	 * Hooks registered menus to WP Admin Dashboard.
	 * 
	 */
	public function __construct()
	{
		add_action('admin_menu', [$this, 'prepareMenus']);
	}

	/**
	 * Iterates through menu/submenu classes and passes it on for 
	 * initialization.
	 *
	 * @return void
	 */
	public function prepareMenus()
	{
		foreach ($this->menus as $menu) :
			$this->initMenu(new $menu);
		endforeach;
	}

	/**
	 * Registers menu/submenu for WP Admin Dashboard.
	 *
	 * @param BaseMenuController $menu
	 * @return void
	 */
    public function initMenu(BaseMenuController $menu)
    {
		$menu->menu();
	}
}