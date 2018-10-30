<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFCartController
{
	public function __construct()
	{
		add_action('woocommerce_cart_calculate_fees', [$this, 'applyDiscount']);
		add_action('woocommerce_order_status_completed', [$this, 'getOrder']);
	}

	public function applyDiscount()
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$discountAmount = $membersController->getMemberDiscount();
		
		if ($discountAmount !== null) {

			$discount = (WC()->cart->subtotal * $discountAmount) / 100;
			WC()->cart->add_fee("You got your " . $discountAmount . "% discount!", -$discount);

		} else {

			if (isset($_SESSION['raf']->memberAffID)) :
				$dicountPercentage = 5;
				
				$discount = (WC()->cart->subtotal * $dicountPercentage) / 100;
				WC()->cart->add_fee("You got your {$dicountPercentage}% discount!", -$discount);
			endif;
		}
	}

	public function getOrder($orderID)
	{
		$order = wc_get_order($orderID);
		$getUserEmail = $order->get_billing_email();

		$this->processMemberDiscount($getUserEmail, $orderID);
	}

	public function processMemberDiscount(string $userEmail, string $orderID)
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$getMember = $membersController->checkValidAffID($_SESSION['raf']->memberAffID);

		if ($getMember) :
			$referedUsers = $membersController->getReferedUsers($getMember->memberID);
			$referedUserKey = array_search($userEmail, $referedUsers);
			$totalRefered = $membersController->getTotalRefered($getMember->memberID);
			$discounts = $membersController->getTotalDiscounts($getMember->memberID);

			if (!array_key_exists($orderID, $totalRefered)) :
				$totalRefered[$orderID] = [
					'orderID' => $orderID,
					'userEmail' => $userEmail
				];

				$discountType = count($totalRefered) > 1 && count($totalRefered) == 5 ? 20 : (
					count($totalRefered) > 5 && count($totalRefered) == 10 ? 40 : (
						count($totalRefered) > 10 && count($totalRefered) == 25 ? 60 : 10
					)
				);

				if (!isset($discounts[$discountType])) :
					$discounts[$discountType] = [
						'isUsed' => 'no',
					];
				endif;

				$toUpdateData['discounts'] = serialize($discounts);
				$toUpdateData['totalRefered'] = serialize($totalRefered);

				$membersController->updateMemberData($getMember->memberID, $toUpdateData);

				unset($_SESSION['raf']->memberAffID);
			endif;

		endif;
	}
}