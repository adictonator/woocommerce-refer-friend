<?php

/**
 * Plugin Name: WooCommerce Refer a Friend
 * Description: The one and only refer a friend extension for WooCommerce!
 * Version: 2.0
 * Author: Sagmetic Infotec Pvt. Ltd.
 * Author URI: https://sagmetic.com
 * License: MIT
 */

define('RAF_ROOT', __FILE__);
define('RAF_ROOT_DIR', dirname(__FILE__));
define('RAF_ROOT_URL', plugin_dir_url(__FILE__));
define('RAF_VENDOR_DIR', RAF_ROOT_DIR . '/vendor');
define('RAF_RESOURCES_DIR', RAF_ROOT_DIR . '/resources');
define('RAF_RESOURCES_URL', RAF_ROOT_URL . '/resources');
define('VIEWS_DIR', RAF_RESOURCES_DIR . '/views');
define('VIEWS_URL', RAF_RESOURCES_URL . '/views');
define('TEMPLATES_DIR', RAF_RESOURCES_DIR . '/templates');
define('TEMPLATES_URL', RAF_RESOURCES_URL . '/templates');
define('VIEW_EXT', '.view.php');
define('DB_DIR', RAF_ROOT_DIR . '/config/db');


require_once 'vendor/bootstrap.php';
