<?php
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

/**
 * 
 */
abstract class Menus
{
	protected $menus = [
		RAFMenuController::class,
		RAFMembersMenuController::class,
		RAFEmailTemplatesMenuController::class,
		RAFSettingsMenuController::class,
	];
}