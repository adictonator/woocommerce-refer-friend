<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

class RAFMembersModel extends BaseModel
{
	protected $table = 'raf_members';
	
	public function create()
	{
		# code...
	}
	public function getAllMembers()
	{
		return $this->dbDriver->get_results(
		"SELECT * FROM {$this->table}"
		);
	}

	public function createMember(array $memberData)
	{
		$this->dbDriver->insert($this->table,
			$memberData
		);

		return $this->getMemberDataBy($memberData['memberID']);
	}

	public function getMemberDataBy($value, $column = 'memberID')
	{
		return $this->dbDriver->get_row(
			"SELECT * FROM {$this->table} WHERE {$column}='{$value}' LIMIT 1"
		);
	}

	public function updateMemberData(int $memberID, array $toUpdateData)
	{
		if (null !== $this->getMemberDataBy($memberID)) {
			$result = $this->dbDriver->update($this->table,
				$toUpdateData,
				['memberID' => $memberID]
			);
		}
	}
}
