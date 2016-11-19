<?php

/*
 * Swift v0.0.1
 * @Author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 * Version 0.0.1
 */

//Init Session
session_start(); 

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', ROOT_DIR .'app/');

try {

	// Includes
	require_once(APP_DIR .'config/config.php');
	require_once(ROOT_DIR .'core/core.php');
	require_once(ROOT_DIR .'core/model.php');
	require_once(ROOT_DIR .'core/view.php');
	require_once(ROOT_DIR .'core/controller.php');
	

	// Define base URL
	global $config;
	define('BASE_URL', $config['base_url']);

	/**
     * Initialize our main class
     * and try/catch any runtime errors
    */
	$Swift = new Swift();
	$Swift->boot();
} catch (Exception $e) {
    echo $e;
}

?>
