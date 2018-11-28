<?php

defined('ABSPATH') or die('Not permitted!');

require 'autoload.php';

use RAF\Helpers\RAFFunctions;
use RAF\Models\RAFInstaller;
use RAF\Controllers\Controller;
use RAF\Controllers\RAFUserAuthCheck;

/** Global RAF Member variable for logged in user. */
$rafMember;

/**
 * Main class for RAF.
 *
 */
final class RAFClass
{
	/**
	 * Instance for the current class.
	 *
	 * @var object RAFClass
	 */
    private static $_instance;

	/**
	 * Check for the instance status.
	 *
	 * @return void
	 */
    protected static function instance()
    {
        if (null === self::$_instance) :
            self::$_instance = new self;

            return self::$_instance;
        endif;
    }

	/**
	 * Let's make sure we have everything.
	 *
	 * @return void
	 */
    public static function start()
    {
		self::instance();
		RAFInstaller::setInstaller();
		RAFFunctions::initSession();
		Controller::plug();
    }
}

RAFClass::start();
