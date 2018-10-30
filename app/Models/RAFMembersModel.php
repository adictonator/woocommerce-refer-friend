<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

class RAFMembersModel 
{
	private $dbDriver = null;

	public function __construct()
	{
		global $wpdb;

		$this->dbDriver = $wpdb;	
	}

	public function getAllMembers()
	{
		return $this->dbDriver->get_results(
			"SELECT * FROM {$this->dbDriver->prefix}raf_members"
		);
	}

	public function createMember(array $memberData)
	{
		$this->dbDriver->insert("{$this->dbDriver->prefix}raf_members",
			$memberData
		);

		return $this->getMemberDataBy($memberData['memberID']);
	}

	public function getMemberDataBy($value, $column = 'memberID')
	{
		try {
			return $this->dbDriver->get_row(
				"SELECT * FROM {$this->dbDriver->prefix}raf_members WHERE {$column}='{$value}' LIMIT 1"
			);
		} catch (\Exception $e) {
			throw $e->getMessage();
		}
	}

	public function updateMemberData(int $memberID, array $toUpdateData)
	{
		if (null !== $this->getMemberDataBy($memberID)) {
			$result = $this->dbDriver->update("{$this->dbDriver->prefix}raf_members",
				$toUpdateData,
				['memberID' => $memberID]
			);
		}
	}
}
