<?php 

defined('ABSPATH') or die('Not permitted!');

require 'autoload.php';
require 'helperPlug.php';

use RAF\Models\RAFInstaller;
use RAF\Controllers\Controller;
use RAF\Controllers\RAFUserAuthCheck;

/** Global RAF Member variable for logged in user. */
$rafMember;

/**
 * 
 */
class RAFClass
{
    private static $_instance;

    protected static function instance()
    {
        if (null === self::$_instance) :
            self::$_instance = new RAFClass;

            return self::$_instance;
        endif;
    }

    public static function start()
    {
		self::instance();
		RAFInstaller::setInstaller();
		HelperPlug::initSession();
		Controller::plug();
    }
}

RAFClass::start();
