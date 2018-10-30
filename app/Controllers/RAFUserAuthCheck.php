<?php
namespace RAF\Controllers;

use RAF\Models\RAFMembersModel;

defined('ABSPATH') or die('Not permitted!');

class RAFUserAuthCheck
{
	public static $userID = null;
	private static $userAuth = false;

	public function __construct()
	{
		self::getLoggedInUser();
	}
	
	public static function getLoggedInUser()
	{
		$checkUser = get_current_user_id();
	
		if ($checkUser > 0) :
			self::$userAuth = true;
			self::$userID = $checkUser;
		endif;

		return self::$userAuth;
	}

	public static function check()
	{
		return self::getLoggedInUser();
	}

	public function getLoggedInRAFMember()
	{
		global $rafMember;

		if (is_null($rafMember)) :
			$membersModel = new RAFMembersModel;
			$rafMember = $membersModel->getMemberDataBy(self::$userID);
		endif;
	}
}
