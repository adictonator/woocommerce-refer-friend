<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

class RAFEmailTemplatesModel 
{
	private static $dbDriver = null;
	private static $table;

	public function __construct()
	{
		global $wpdb;

		self::$dbDriver = $wpdb;
		self::$table = self::$dbDriver->prefix . 'raf_email_templates';
	}

	public static function init()
	{
		return new RAFEmailTemplatesModel;
	}

	public static function getEmailTemplateData(string $emailTemplateID)
	{
		return self::$dbDriver->get_row("SELECT * FROM " . self::$table . " WHERE templateID='{$emailTemplateID}' LIMIT 1");
	}

	public static function createEmailTemplate(array $emailTemplateData)
	{
		self::$dbDriver->insert(self::$table, $emailTemplateData);
	}
	
	public static function updateEmailTemplate(array $emailTemplateData)
	{
		self::$dbDriver->update(self::$table,
			$emailTemplateData,
			['templateID' => $emailTemplateData['templateID']]
		);
	}

	public static function getSubject(string $emailTemplateID)
	{
		$emailTemplateData = self::getEmailTemplateData($emailTemplateID);

		return isset($emailTemplateData->subject) ? $emailTemplateData->subject : '';
	}
	
	public static function getContent(string $emailTemplateID)
	{
		$emailTemplateData = self::getEmailTemplateData($emailTemplateID);

		return isset($emailTemplateData->content) ? stripcslashes(html_entity_decode($emailTemplateData->content)) : '';
	}
}