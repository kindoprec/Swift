<?php 

/*
 * Swift Config file
 * @author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 */

date_default_timezone_set('North America/Florida');

if (stripos($_SERVER['HTTP_HOST'], 'localhost') === 0) {

	$config['base_url'] = 'http://localhost/swift/'; // Base URL including trailing slash (e.g. http://localhost/swift:9000/)

	$config['db_host'] = 'localhost'; // Database host (e.g. localhost)
	$config['db_name'] = 'hoztal'; // Database name
	$config['db_username'] = 'root'; // Database username
	$config['db_password'] = ''; // Database password

}

?>