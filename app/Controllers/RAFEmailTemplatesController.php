<?php
namespace RAF\Controllers;

use RAF\Models\RAFEmailTemplatesModel;

defined('ABSPATH') or die('Not permitted!');

class RAFEmailTemplatesController implements RAFControllerInterface
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

	public function processTemplateData()
	{
		$emailTemplate = RAFEmailTemplatesModel::init()->getEmailTemplateData($_POST['emailTemplateID']);
		
		$toUpdateData = [
			'templateID' => esc_html($_POST['emailTemplateID']),
			'subject' => esc_html($_POST['subject']),
			'content' => esc_html($_POST['content']),
		];

		if (null !== $emailTemplate) :
			RAFEmailTemplatesModel::updateEmailTemplate($toUpdateData);
		else:
			RAFEmailTemplatesModel::createEmailTemplate($toUpdateData);
		endif;

		$_SESSION['raf']->adminFlash = (object) [
			'type' => 'success',
			'msg' => 'Templates updated successfully!',
		];

		wp_redirect(wp_get_referer());
		exit;
	}
}
