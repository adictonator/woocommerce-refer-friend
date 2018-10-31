<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;
use RAF\Models\RAFReferedUsersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFReferedUsersController
{
	private $model = null;

	public function __construct(RAFReferedUsersModel $referedUsersModel)
	{
		$this->model = $referedUsersModel;
	}

	public function prepareReferedUserData($dataObj, $order, $isUser = 1)
	{
		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);

		$referedUserData = [
			'userEmail' => $order->get_billing_email(),
			'orderID' => $order->get_id(),
			'referedAffID' => $dataObj->memberAffID,
			'isUser' => $isUser,
		];

		$this->createReferedUser($referedUserData);
	}

	public function createReferedUser(array $referedUserData)
	{
		$this->model->createReferedUser($referedUserData);
	}

	public function getReferedUserData(string $orderID)
	{
		return $this->model->getReferedUserData($orderID);
	}

}