<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

class RAFReferedUsersModel 
{
	private $dbDriver = null;
	private $table;

	public function __construct()
	{
		global $wpdb;

		$this->dbDriver = $wpdb;
		$this->table = $this->dbDriver->prefix . 'raf_refered_users';
	}

	public function createReferedUser(array $userData)
	{
		return $this->dbDriver->insert($this->table,
			$userData
		);
	}
	
	public function getReferedUserData(string $orderID)
	{
		try {
			return $this->dbDriver->get_row(
				"SELECT * FROM {$this->table} WHERE orderID='{$orderID}' LIMIT 1"
			);
		} catch (\Exception $e) {
			throw $e->getMessage();
		}
	}
}
