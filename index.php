<?php

/*
 * Swift v0.0.1
 * @author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 */

//Init Session
session_start(); 

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', ROOT_DIR .'app/');

// Includes
require_once(APP_DIR .'config/config.php');
require_once(ROOT_DIR .'core/model.php');
require_once(ROOT_DIR .'core/view.php');
require_once(ROOT_DIR .'core/controller.php');
require_once(ROOT_DIR .'core/core.php');

// Define base URL
global $config;
define('BASE_URL', $config['base_url']);

ob_start();
$Swift = new Swift();
$Swift->boot();
ob_end_clean();

?>
