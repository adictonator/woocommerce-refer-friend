<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;
use RAF\Models\RAFEmailTemplatesModel;

defined('ABSPATH') or die('Not permitted!');

class RAFReferController implements RAFControllerInterface
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

	public function processRefer()
	{
		global $rafMember;

		$membersModel = new RAFMembersModel;
		$membersController = new RAFMembersController($membersModel);
		
		if (false === RAFUserAuthCheck::check()) {
			//$returnData = $this->triggerAuth();
		} else {
			if (is_null($rafMember) || $rafMember->memberID <= 0) :
				$rafMember = $membersController->checkStatus();
			endif;
		}
		
		$referedMembers = $membersController->getReferedUsers($rafMember->memberID);

		if (!in_array($_POST['rafReferEmail'], $referedMembers)) {
			$isProcessComplete = $this->processFormData($_POST);

			$referedMembers[] = esc_html($_POST['rafReferEmail']);
			$toUpdateData['referedUsers'] = serialize($referedMembers);

			$updateMemberData = $membersController->updateMemberData($rafMember->memberID, $toUpdateData);
		} else {
			echo 'alreayd there';
		}
	}

	private function processFormData(array $formData)
	{
		$referName = esc_html($formData['rafReferName']);
		$referEmail = esc_html($formData['rafReferEmail']);
		$referMessage = esc_html($formData['rafReferMessage']);

		$emailData = (object) [
			'to' => $referEmail,
			'message' => $referMessage,
			'name' => $referName
		];
  
		return $this->triggerEmail($emailData);
	}

	private function triggerEmail($emailData)
	{
		global $rafMember;

		$emailHeaders = "From: noreply@" . $_SERVER['SERVER_NAME'] . "\r\n";
		$emailHeaders .= "MIME-Version: 1.0\r\n";
		$emailHeaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$link = '<a href="' . get_permalink(wc_get_page_id('shop')) . '?raf-mem=' . $rafMember->memberAffID .'">Click Here to get your discount!</a>';

		RAFEmailTemplatesModel::init();
		$emailSubject = RAFEmailTemplatesModel::getSubject('email');
		$emailContent = RAFEmailTemplatesModel::getContent('email');
		$emailContent = str_replace('%refer_link%', $link, $emailContent);
		$emailContent = str_replace('%customer_email%', $emailData->to, $emailContent);
		$emailContent .= "<br /><br />";
		$emailContent .= $emailData->message;

		wp_mail($emailData->to, $emailSubject, $emailContent, $emailHeaders);
	}

	public static function checkRAFAffURL()
	{
		if (isset($_GET['raf-mem']) && !empty($_GET['raf-mem'])) :

			$membersModel = new RAFMembersModel;
			$membersController = new RAFMembersController($membersModel);
			$isValid = $membersController->checkValidAffID($_GET['raf-mem']);

			if ($isValid) :
				$_SESSION['raf'] = (object) [
					'memberAffID' => $_GET['raf-mem'],
				];
			else:
				unset($_SESSION['raf']->memberAffID);
			endif;

		endif;
	}
}
