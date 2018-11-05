<?php
namespace RAF\Models;

abstract class BaseModel
{
	protected $dbDriver;
	protected $table;

	public function __construct()
	{
		global $wpdb;

		$this->dbDriver = $wpdb;
		$this->table = $this->dbDriver->prefix . 'raf_members';
	}
}
