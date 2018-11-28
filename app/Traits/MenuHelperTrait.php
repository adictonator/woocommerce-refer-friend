<?php
namespace RAF\Traits;

use RAF\Helpers\RAFConstants;

trait MenuHelperTrait
{
	public function prepareString(string $string)
	{
		return str_replace([' ', '_'], '-', strtolower($string));
	}

	public function menuSlug(string $string)
	{
		return RAFConstants::PLUGIN_SLUG . '-' . $this->prepareString($string);
	}

	public function menuTitle(string $title)
	{
		return RAFConstants::PLUGIN_PAGE_TITLE . $title;
	}
}