<?php

include 'core.php';

class Model extends Swift {

	private $connection;

	public function __construct()
	{
		/**
		* Database connection
		* Constructor
		* @param string DB_HOST
		* @param string DB_NAME
		* @param string DB_USERNAME
		* @param string DB_PASSWORD
		*/
		global $config;

		try {
			# SQLite Database
			#$this->connection = new PDO("sqlite:my/path/to/database.db");

			# MySQL with PDO_MYSQL
			$this->connection = new \PDO('mysql:host='.$config['db_host'].'; dbname='.$config['db_name'],  $config['db_username'], $config['db_password']);
	    } 
	    catch (PDOException $e){
	      	echo $e->getMessage();
	    	file_put_contents(ROOT_DIR .'temp/pdo-errors.txt', $e->getMessage(), FILE_APPEND);
	    	die();
	    }
	}

	public function _escstr($string)
	{
		return mysql_real_escape_string($string);
	}
	
	public function _bool($val)
	{
	    return !!$val;
	}
	
	public function _date($val)
	{
	    return date('Y-m-d', $val);
	}
	
	public function _time($val)
	{
	    return date('H:i:s', $val);
	}
	
	public function _now($val)
	{
	    return date('Y-m-d H:i:s', $val);
	}

	public function query($qry)
	{
		$this->addToLog($qry);
		$result = $this->connection->query($qry) or die('Error: '. mysql_error());
		return $result;
	}

	public function save($qry, $data=array())
	{
		$exec = $this->connection->$qry;
		$result = $exec->execute($data) or die('Error: '. mysql_error());
		return $result;
	}
    
}
?>
