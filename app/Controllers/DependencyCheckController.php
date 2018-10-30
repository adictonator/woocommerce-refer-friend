<?php
namespace RAF\Controllers;

defined('ABSPATH') or die('Not permitted!');

class DependencyCheckController
{
	public function __construct()
	{
		self::wooCommerceCheck();
	}

	private static function wooCommerceCheck()
	{
		if (!class_exists('WooCommerce')) {
			add_action('admin_notices', [__CLASS__, 'noWooCommerceNotice']);
		}
	}

	public static function noWooCommerceNotice()
	{
		self::resolveNoticeViewPath('dependency', 'woocommerce');

		/** Do not proceed with WooCommerce is not activated. */
		deactivate_plugins(RAF_ROOT);	
	}

	private static function resolveNoticeViewPath($folder = 'dependency', $template = 'woocommerce')
	{
		require_once RAF_RESOURCES_DIR . "/notices/{$folder}/{$template}" . VIEW_EXT;
	}
}
