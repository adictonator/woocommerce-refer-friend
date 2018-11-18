<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

abstract class BaseModel
{
	protected $dbDriver;

	public function __construct()
	{
		global $wpdb;

		$this->dbDriver = $wpdb;
		$this->table = $this->dbDriver->prefix . $this->table;
	}

	// abstract protected function insert($data);

	// abstract protected function get($id);

	// abstract protected function update($id, $data);

	// abstract protected function delete($id);
}
