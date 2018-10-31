<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;
use RAF\Models\RAFReferedUsersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFCartController
{
	public function __construct()
	{
		add_action('woocommerce_cart_calculate_fees', [$this, 'applyDiscount']);
		add_action('woocommerce_checkout_order_processed', [$this, 'processReferedUserData']);
		add_action('woocommerce_order_status_completed', [$this, 'getOrder']);
	}

	public function applyDiscount()
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$discountAmount = $membersController->getMemberDiscount();
		
		if ($discountAmount !== null) :
			
			$discount = (WC()->cart->subtotal * $discountAmount) / 100;
			WC()->cart->add_fee("You got your {$discountAmount}% discount!", -$discount);
			
		elseif (isset($_SESSION['raf']->memberAffID)):
			
			$discountAmount = 5;
			$discount = (WC()->cart->subtotal * $discountAmount) / 100;
			WC()->cart->add_fee("You got your {$discountAmount}% discount!", -$discount);

		endif;

	}

	public function getOrder($orderID)
	{
		$order = wc_get_order($orderID);
		$getUserEmail = $order->get_billing_email();

		$this->processMemberDiscounts($getUserEmail, $order);
	}

	public function processReferedUserData($orderID)
	{
		global $rafMember;

		if (isset($_SESSION['raf']->memberAffID)) :
			
			$dataObj = (object) [
				'memberAffID' => $_SESSION['raf']->memberAffID,
			];
			$isUser = 1;
		
		elseif (null !== $rafMember):

			$dataObj = (object) [
				'memberAffID' => $rafMember->memberAffID,
			];
			$isUser = 0;
			
		endif;

		$order = wc_get_order($orderID);
		$getUserEmail = $order->get_billing_email();

		$referedUsersModel = new RAFReferedUsersModel;
		$referedUsersController = new RAFReferedUsersController($referedUsersModel);
		$referedUsersController->prepareReferedUserData($dataObj, $order, $isUser);
	}

	public function processMemberDiscounts(string $userEmail, $order)
	{
		$orderID = $order->get_id();
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);

		$referedUsersModel = new RAFReferedUsersModel;
		$referedUsersController = new RAFReferedUsersController($referedUsersModel);
		$referedUserData = $referedUsersController->getReferedUserData($orderID);

		if ($referedUserData->isUser == 1) :
			$membersController->addMemberDiscounts($order, $userEmail);
		else:
			$membersController->updateMemberDiscounts($order, $referedUserData->referedAffID);
		endif;
	}
}