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
		add_action('woocommerce_before_calculate_totals', [$this, 'specialDiscountApply']);
		
	}

	public function aNotice()
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$prodData = $membersController->getMemberDiscount();

		foreach (WC()->cart->get_cart() as $cartItem) {
			$prodIDs[] = $cartItem['product_id'];
		}

		if (!in_array($prodData['prodID'], $prodIDs)) {
			echo "<div class='woocommerce-info'>{$prodData['msg']}</div>";
		}
	}

	public function specialDiscountApply()
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$prodID = $membersController->getMemberDiscount();

		if ( is_admin() && ! defined( 'DOING_AJAX' ) )
			return;

		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
			return;

		foreach (WC()->cart->get_cart() as $cartItem) {
			if ($cartItem['product_id'] == $prodID['prodID']) {
				$cartItem['data']->set_price(0);
			}
		}		
	}

	public function removeQuantityField($return, $product)
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$prodID = $membersController->getMemberDiscount();

		if ($product->get_id() == $prodID['prodID']) {
			return true;
		}
	}

	public function applyDiscount()
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		$discountAmount = $membersController->getMemberDiscount();
		
		if (is_array($discountAmount)) :

			add_action('woocommerce_before_cart', [$this, 'aNotice']);
			add_action('woocommerce_before_checkout_form', [$this, 'aNotice'], 5);
			add_filter('woocommerce_is_sold_individually', [$this, 'removeQuantityField'], 10, 2);
			
		elseif ($discountAmount !== null):
			
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