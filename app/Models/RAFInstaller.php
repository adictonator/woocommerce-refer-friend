<?php
namespace RAF\Models;

defined('ABSPATH') or die('Not permitted!');

class RAFInstaller
{
	private static $dbDriver = null;

	private static function resolveSQLPath(string $filePath)
	{
		$sqlContent = file_get_contents($filePath);
		$sqlContent = trim($sqlContent, '\n\r\0x20;');

		$sqlCommands = explode(';', $sqlContent);
		$sqlCommands = array_filter($sqlCommands);
		
		foreach ($sqlCommands as $sqlCommand) :

			$sqlCommand = self::resolveSQL($sqlCommand);

			self::$dbDriver->query("{$sqlCommand};");

		endforeach;
	}

	private static function resolveSQL(string $sqlData)
	{
		$correctSQLData = trim($sqlData, '\n\r\0x20;');
		$correctSQLData = str_replace('###', self::$dbDriver->prefix, $correctSQLData);
		$correctSQLData = str_replace('~~~COLLATE', self::$dbDriver->get_charset_collate(), $correctSQLData);

		return $correctSQLData;
	}

	public static function setInstaller()
	{
		global $wpdb;
		self::$dbDriver = $wpdb;

		register_activation_hook(RAF_ROOT, [__CLASS__, 'installDB']);
		register_uninstall_hook(RAF_ROOT, [__CLASS__, 'uninstallDB']);
	}

	public static function installDB()
	{
		self::resolveSQLPath(DB_DIR . '/tables.sql');
	}

	public static function uninstallDB()
	{
		self::resolveSQLPath(DB_DIR . '/uninstaller.sql');
	}
}
