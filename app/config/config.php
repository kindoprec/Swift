<?php 

/**
 * Swift Config file
 * @Author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 * Version 0.0.1
 */

date_default_timezone_set('America/Los_Angeles');

if (stripos($_SERVER['HTTP_HOST'], 'localhost') === 0) {

	$config = array(
	    'base_url'   => 'http://localhost/swift/', // Base URL including trailing slash (e.g. http://localhost/swift:9000/)
	    'db_host'   => 'localhost', // Usually localhost
	    'db_name' => 'hoztal', // The database name
	    'db_username' => 'root', // The database username
	    'db_password' => '', // The database password
	    'verbose' => false // If true errors will be shown
	);

}

?>