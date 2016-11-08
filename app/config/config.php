<?php 

/*
 * Swift Config file
 * @author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 */

date_default_timezone_set('America/Los_Angeles');

if (stripos($_SERVER['HTTP_HOST'], 'localhost') === 0) {

	$config['base_url'] = ''; // Base URL including trailing slash (e.g. http://localhost/swift:9000/)

	$config['db_host'] = ''; // Database host (e.g. localhost)
	$config['db_name'] = ''; // Database name
	$config['db_username'] = ''; // Database username
	$config['db_password'] = ''; // Database password

}

?>