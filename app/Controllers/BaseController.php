<?php
namespace RAF\Controllers;

use RAF\Models\BaseModel;

abstract class BaseController
{
	protected $model;

	public function __construct(BaseModel $model)
	{
		$this->model = $model;
	}
}
