<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFMembersController
{
	private $model = null;

	public function __construct(RAFMembersModel $membersModel)
	{
		$this->model = $membersModel;
	}

	public function getAllMembers()
	{
		return $this->model->getAllMembers();
	}

	public function checkStatus()
	{
		$userData = $this->model->getMemberDataBy(RAFUserAuthCheck::$userID);

		if ($userData <= 0) :
			$userData = $this->model->createMember($this->prepareMemberData());
		endif;

		return $userData;
	}

	private function generateMemberAffiliateID(string $userEmail)
	{
		return md5($userEmail);
	}

	public function checkValidAffID(string $affID)
	{
		return $this->model->getMemberDataBy($affID, 'memberAffID');
	}
	
	private function prepareMemberData()
	{
		$getUserData = wp_get_current_user();

		$memberEmail = $getUserData->user_email;
		$memberAffID = $this->generateMemberAffiliateID($memberEmail);

		return $memberData = [
			'memberID' => $getUserData->ID,
			'memberEmail' => $memberEmail,
			'memberAffID' => $memberAffID,
		];
	}

	// public function getMemberAffID(int $memberID)
	// {
	// 	$data = $this->model->getMemberData($memberID);

	// 	return $data->memberAffID;
	// }

	public function getReferedUsers(int $memberID)
	{
		$data = $this->model->getMemberDataBy($memberID);

		return unserialize($data->referedUsers);
	}
	
	public function getTotalRefered(int $memberID)
	{
		$data = $this->model->getMemberDataBy($memberID);

		return unserialize($data->totalRefered);
	}
	
	public function getTotalDiscounts(int $memberID)
	{
		$data = $this->model->getMemberDataBy($memberID);

		return unserialize($data->discounts);
	}
	
	public function getAvailableDiscounts(int $memberID)
	{
		$data = $this->getTotalDiscounts($memberID);

		$data = !$data ? [] : $data;

		$checkData = array_filter($data, function($checkData) {
			if ($checkData['isUsed'] == 'no') {
				return $checkData;
			}
		});

		return $checkData;
	}

	public function updateMemberData(int $memberID, array $toUpdateData)
	{
		$this->model->updateMemberData($memberID, $toUpdateData);
	}

	public function applyMemberDiscount()
	{
		$kk = $this->getAvailableDiscounts(1);

		if ($kk > 0) {
			foreach ($kk as $amount => $ll) {
				$sumDiscount += $amount;
			}

			echo "<pre>";
			echo 'asdsa';
			print_r($sumDiscount);
			echo "</pre>";

			RAFCartController::applyDiscount($sumDiscount);
		}
	}
}
