<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFTemplatesController implements RAFControllerInterface
{
	public function __construct(array $data)
	{
		$this->processData($data);
	}

	public function processData(array $data)
	{
		$this->resolveAction($data['rafAction']);
	}

	public function resolveAction(string $actionStub)
	{
		if (method_exists($this, $actionStub)) :
			$this->{$actionStub}();
		endif;
	}

	private function referProduct()
	{
		global $rafMember;

		if (false === RAFUserAuthCheck::check()) {

			$returnData = $this->triggerAuth();

		} else {

			if (is_null($rafMember) || $rafMember->memberID <= 0) :
				$membersModel = new RAFMembersModel;
				$membersController = new RAFMembersController($membersModel);
				$rafMember = $membersController->checkStatus();
			endif;

			if ($rafMember->memberID > 0) :
				$returnData = [
					'type' => 'success',
					'memberAffID' => $rafMember->memberAffID,
				];

				if (empty($rafMember->memberAffID)) :
					$returnData = [
						'type' => 'error',
						'msg' => 'Very weird!',
					];
				endif;
			endif;
		}

		echo json_encode($returnData);
	}

	private function triggerAuth()
	{
		return $returnData = [
			'type' => 'error',
			'msg' => 'Please login first!',
		];
	}
}
