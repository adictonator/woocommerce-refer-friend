<?php
namespace RAF\Controllers;

defined('ABSPATH') or die('Not permitted!');

use RAF\Models\BaseModel;

abstract class BaseController
{
	protected $model;

	public function __construct(BaseModel $model)
	{
		$this->model = $model;
	}
}
