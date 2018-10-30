<?php
namespace RAF\Controllers\Menus;

defined('ABSPATH') or die('Not permitted!');

interface MenuInterface
{
    public function menu();

    public function menuFunction();

    public function menuView($menuSlug);

    public function menuAssets();
}