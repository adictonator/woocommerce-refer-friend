<?php
namespace RAF\Controllers;

use RAF\Controllers\Menus\AdminMenusController;

defined('ABSPATH') or die('Not permitted!');

/**
 *
 */
class Controller
{
    public static function plug()
    {
		self::plugMenus();
		self::plugRoutesListen();
		add_action('plugins_loaded', [__CLASS__, 'plugDependencyCheck']);
		self::plugTemplateViewController();
		add_action('init', [__CLASS__, 'plugMemberAuthCheck']);
		add_action('init', [__CLASS__, 'checkRAFAffURL']);
		add_action( 'admin_init', [__CLASS__, 'admin_redirects']);
		self::plugRAFCart();
	}

	public static function admin_redirects()
	{
		if (isset($_GET['raf-setup'])) :
			ob_start();
			echo 'lmao';
			exit;
		endif;
	}

    public static function plugMenus()
    {
		new AdminMenusController;
	}

	private static function plugRoutesListen()
	{
		$routes = new RAFRoutesController;

		add_action('admin_post_listen', [$routes, 'listen']);
		add_action('admin_post_nopriv_listen', [$routes, 'listen']);
		add_action('wp_ajax_listenAJAX', [$routes, 'listenAJAX']);
		add_action('wp_ajax_nopriv_listenAJAX', [$routes, 'listenAJAX']);
	}

	private static function plugTemplateViewController()
	{
		return new TemplateViewController;
	}

	public static function plugDependencyCheck()
	{
		return new DependencyCheckController;
	}

	public static function plugMemberAuthCheck()
	{
		$authMember = new RAFUserAuthCheck;
		return $authMember->getLoggedInRAFMember();
	}

	public static function checkRAFAffURL()
	{
		return RAFReferController::checkRAFAffURL();
	}

	public static function plugRAFCart()
	{
		return new RAFCartController;
	}
}