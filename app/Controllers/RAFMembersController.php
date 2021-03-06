<?php
namespace RAF\Controllers;

use RAF\Models\RAFSettingsModel;
use RAF\Models\RAFMembersModel;
use RAF\Models\RAFReferedUsersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFMembersController extends BaseController
{
	public function __construct()
	{
		parent::__construct(new RAFMembersModel);
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

	public function checkValidAffID($affID)
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
	
	public function getReferedUsers(int $memberID)
	{
		$data = $this->model->getMemberDataBy($memberID);

		return !empty($data->referedUsers) ? unserialize($data->referedUsers) : [];
	}
	
	public function getTotalRefered(int $memberID)
	{
		$data = $this->model->getMemberDataBy($memberID);

		return !empty($data->totalRefered) ? unserialize($data->totalRefered) : [];
	}
	
	public function getTotalDiscounts(int $memberID)
	{
		$data = $this->model->getMemberDataBy($memberID);

		return !empty($data->discounts) ? unserialize($data->discounts) : [];
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

	/**
	 * @return int|null - Discount amount
	 */
	public function getMemberDiscount()
	{
		global $rafMember;

		$sumDiscount = null;
		
		if (null !== $rafMember) :
			$availableDiscounts = $this->getAvailableDiscounts($rafMember->memberID);

			if ($availableDiscounts > 0) {
				foreach ($availableDiscounts as $amount => $discount) {
					if (is_int($amount)) :
						$sumDiscount += $amount;
					else:
						$sumDiscount = $this->resolveSpecialDiscount($amount, $availableDiscounts);
					endif;
				}
			}
		endif;

		return $sumDiscount;
	}

	public function resolveSpecialDiscount($discountType, $availableDiscounts)
	{
		$discountAmount = null;

		if (strpos($discountType, 'freeProd-') !== false) {
			if (isset($availableDiscounts[$discountType])) :
				$discountAmount = $this->getSpecialDiscount($discountType, $availableDiscounts);
			endif;
		}

		return $discountAmount;
	}

	public function getSpecialDiscount($discountType, $availableDiscounts)
	{
		$prodID = $availableDiscounts[$discountType]['prodID'];
		$theProd = wc_get_product($prodID);

	   return ['msg' => $theProd->get_name() . ' is free for you! <a href="?add-to-cart=' . $theProd->get_id() . '">Add to the cart</a>', 'prodID' => $prodID];
	}

	public function addMemberDiscounts($order, $userEmail)
	{
		$orderID = $order->get_id();
		$referedUsersModel = new RAFReferedUsersModel;
		$referedUsersController = new RAFReferedUsersController($referedUsersModel);
		$referedUserData = $referedUsersController->getReferedUserData($orderID);

		$getMember = $this->checkValidAffID($referedUserData->referedAffID);

		if ($getMember) :
			$referedUsers = $this->getReferedUsers($getMember->memberID);
			//$referedUserKey = array_search($userEmail, $referedUsers);
			$totalRefered = $this->getTotalRefered($getMember->memberID);
			$discounts = $this->getTotalDiscounts($getMember->memberID);

			/** So that we don't accidently update the data again if same order gets its status changed again. */
			if (!array_key_exists($orderID, $totalRefered)) :
				$totalRefered[$orderID] = [
					'orderID' => $orderID,
					'userEmail' => $userEmail
				];

				$allDiscounts = RAFSettingsModel::init()->getDiscountsData();

	

				foreach ($allDiscounts as $totalReferdCount => $discount) :
					if (isset($discount['discount'])) :

						$discountType = count($totalRefered) == $totalReferdCount ? $discount['discount'] : null;

					elseif (!isset($discount['discount'])) :
						$prodID = array_values($discount);

						$discountType = count($totalRefered) == $totalReferdCount ? ['discountKey' => key($discount), 'totalRefered' => $totalReferdCount, 'prodID' => $prodID[0]] : $discountType;

					endif;
				endforeach;

			

				// $discountType = count($totalRefered) > 1 && count($totalRefered) == 5 ? 20 : (
				// 	count($totalRefered) > 5 && count($totalRefered) == 10 ? 'freeProd-1' : (
				// 		count($totalRefered) > 10 && count($totalRefered) == 25 ? 'freeProd-2' : 10
				// 	)
				// );

				/** Only create discount if it doesn't exists already. */
				if (is_array($discountType) && !isset($discounts[$discountType['discountKey']])) :
					$discounts[$discountType['discountKey']] = [
						'isUsed' => 'no',
						'prodID' => $discountType['prodID']
					];
				elseif (!isset($discounts[$discountType])) :
					$discounts[$discountType] = [
						'isUsed' => 'no',
					];
				endif;

				$toUpdateData['discounts'] = serialize($discounts);
				$toUpdateData['totalRefered'] = serialize($totalRefered);

				$this->updateMemberData($getMember->memberID, $toUpdateData);

			endif;

		endif;
	}

	public function updateMemberDiscounts($order, string $affID)
	{
		$orderID = $order->get_id();
		$memberData = $this->model->getMemberDataBy($affID, 'memberAffID');
		$memberID = $memberData->memberID;

		$discounts = $this->getAvailableDiscounts($memberID);

		foreach( $order->get_items('fee') as $item_id => $item_fee ){
			$appliedDiscount = filter_var($item_fee->get_name(), FILTER_SANITIZE_NUMBER_INT);
			break;
		}

		if (!isset($discounts[$appliedDiscount])) :
			// resolve discount

			if ($appliedDiscount == 30) {
				$multiDiscounts = [10, 20];
			}

			if (isset($multiDiscounts)) :
				foreach ($multiDiscounts as $multiDiscount) :
					$discounts[$multiDiscount]['isUsed'] = 'yes';
					$discounts[$multiDiscount]['orderID'] = $orderID;
				endforeach;
			endif;

		else:

			$discounts[$appliedDiscount]['isUsed'] = 'yes';
			$discounts[$appliedDiscount]['orderID'] = $orderID;

		endif;

		$toUpdateData['discounts'] = serialize($discounts);

		$this->updateMemberData($memberID, $toUpdateData);
	}
}
