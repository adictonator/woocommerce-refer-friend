<?php
namespace RAF\Traits;

use HelperPlug;

trait MenuHelperTrait
{
	public function prepareString(string $string)
	{
		return str_replace([' ', '_'], '-', strtolower($string));
	}

	public function menuSlug(string $string)
	{
		return HelperPlug::PLUGIN_SLUG . '-' . $this->prepareString($string);
	}

	public function menuTitle(string $title)
	{
		return HelperPlug::PLUGIN_PAGE_TITLE . $title;
	}
}