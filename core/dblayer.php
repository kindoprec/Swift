<?php

/**
 * Swift Database Wrapper
 *
 * Default SQL Database is on top of PDO
 *
 * For SQlite users: $this->connection = new PDO("sqlite:my/path/to/database.db");
 *
 * @Author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 * Version 0.0.1
 */

class DbLayer {

	private $connection;
    private $_config;
	private $_query;
	private $_error;
	private $_verbose;

	private $_buildQuery; // use heap method to stack queries, there pretty should be better ways

	public function __construct($config)
	{
        $this->_config = $config;

		/*try {
			# SQLite Database
			#$this->connection = new PDO("sqlite:my/path/to/database.db");

			# MySQL with PDO_MYSQL
			$this->connection = new \PDO('mysql:host='.$config['db_host'].'; dbname='.$config['db_name'],  $config['db_username'], $config['db_password']);
	    } 
	    catch (PDOException $e){
	      	echo $e->getMessage();
	    	file_put_contents(ROOT_DIR .'temp/pdo-errors.txt', $e->getMessage(), FILE_APPEND);
	    	die();
	    }*/
	}

	/*
     * Initializes the database.  
     * Checks the configuration, connects, selects database.
     */
    public function init() 
    {
        if(!$this->__check_config()) {
            return false;
        }

        if(!$this->__connect()) {
            return false;
        }

        return true;
    }

	/*
     * Checks the configuration for blanks.
     */
    private function __check_config() 
    {
        $config = $this->_config;

        if(empty($config["db_host"]) || empty($config["db_username"]) || empty($config["db_name"])) {
            $this->_error = "Configuration details were blank.";
            return false;
        }

        $this->_verbose = ($config["verbose"]) ? true : false;

        return true;
    }

    /*
     * Connects to the database.
     */
    private function __connect() 
    {
        /**
        * Database connection
        * Constructor
        * @param string DB_HOST
        * @param string DB_NAME
        * @param string DB_USERNAME
        * @param string DB_PASSWORD
        */
    	$config = $this->_config;

        $this->connection = new \PDO('mysql:host='.$config['db_host'].'; dbname='.$config['db_name'],  $config['db_username'], $config['db_password']);

        if(!$this->connection) {
            $this->_error = ($this->_verbose) ? mysql_error() : "Could not connect to database.";
            return false;
        }

        return true;
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

	/* 
	 * Custom ORM queries inpired by Flask-SQLAchemy
	 */
	/*
     * SELECT starter.  $fields can be either a string or an array of strings to select.
     */
    public function select($fields) 
    {
        $query = "SELECT";

        if(!empty($fields) && !is_array($fields)) {
            $query .= " {$fields}";
        } else if(is_array($fields)) {
            $query .= " `";
            $query .= implode("`,`", $fields);
            $query .= "`";
        } else {
            $query .= " *";
        }

        $this->_buildQuery = $query;
        return $this;
    }

    /*
     * Adds where the SELECT is going to be coming from (table wise).
     * select("*")
     * select("username")
     * select(array("username", "password"))
     */
    public function from($table) 
    {
        $this->_buildQuery .= " FROM `{$table}`";
        return $this;
    }

    /*
     * UPDATE starter.
     * update("users")
     */
    public function update($table) 
    {
        $this->_buildQuery = "UPDATE `{$table}`";
        return $this;
    }
    
    /*
     * DELETE starter.
     * delete("users")
     */
    public function delete($table) 
    {
        $this->_buildQuery = "DELETE FROM `{$table}`";
        return $this;
    }

    /*
     * INSERT starter.  $data is an array matched columns to values:
     * $data = array("username" => "John", "email" => "someone@email.com");
     * insert("users", array("username" => "John", "password" => "somehash"))
     */
    public function insert($table, $data) 
    {
        $query = "INSERT INTO `{$table}` (";
        $keys   = array_keys($data);
        $values = array_values($data);
        
        $query .= implode(", ", $keys);
        $query .= ") VALUES (";
        
        $array  = array();
        
        foreach($values as $value) {
            $array[] = "'{$value}'";
        }
        
        $query .= implode(", ", $array) . ")";
        
        $this->_buildQuery = $query;
        return $this;
    }

    /*
     * SET.  $data is an array matched key => value.
     * set(array("username" => "Caleb"))
     */
    public function set($data) 
    {
        if(!is_array($data)) return $this;
        
        $query =  "SET ";
        $array = array();

        foreach($data as $key => $value) {
            $array[] = "`{$key}`='{$value}'";
        }

        $query .= implode(", ", $array);

        $this->_buildQuery .= " " . $query;
        return $this;
    }

    /*
     * WHERE.  $fields and $values can either be strings or arrays based on how many you need.
     * $operators can be an array to add in <, >, etc.  Must match the index for $fields and $values.
     * where("username", "Caleb")
     * where(array("username", "password"), array("Caleb", "testing"))
     * where(array("username", "level"), array("Caleb", "10"), array("=", "<"))
     */
    public function where($fields, $values, $operators = '') 
    {
        if(!is_array($fields) && !is_array($values)) {
            $operator = (empty($operators)) ? '=' : $operators[0];
            $query = " WHERE `{$fields}` {$operator} '{$values}'";
        } else {
            $array = array_combine($fields, $values);
            $query = " WHERE ";

            $data  = array();
            $counter = 0;

            foreach($array as $key => $value) {

                $operator = (!empty($operators) && !empty($operators[$counter])) ? $operators[$counter] : '=';

                $data[] = "`{$key}` {$operator} '{$value}'";

                $counter++;
            }

            $query .= implode(" AND ", $data);
        }

        $this->_buildQuery .= $query;
        return $this;
    }

    /*
     * Order By:
     * order_by("username", "asc")
     */
    public function order_by($field, $direction = 'asc') 
    {
        if($field) $this->_buildQuery .= " ORDER BY `{$field}` " . strtoupper($direction);
        return $this;
    }

    /*
     * Limit:
     * limit(1)
     * limit(1, 0)
     */
    public function limit($max, $min = '0') 
    {
        if($max) $this->_buildQuery .= " LIMIT {$min},{$max}";
        return $this;
    }

    /*
     * Will return the object of data from the query.
     */
    public function fetch_object() 
    {
        $this->_query->setFetchMode(PDO::FETCH_OBJ);

        $objects = array();
        while($object = $this->_query->fetch()) {
            $objects[] = $object;
        }

        if(!$object && $this->_verbose) {
            $this->_error = mysql_error();
        }

        return $objects;
    }

    /*
     * Will return the array of data from the query.
     */
    public function fetch_array() 
    {

        $this->_query->setFetchMode(PDO::FETCH_ASSOC);
        $_array = $this->_query->fetch();
        if($_array){
            foreach($_array as $key=>$val){ 
                if(is_numeric($key)){ 
                    unset($_array[$key]); 
                } 
            }
        }

        if(!$_array && $this->_verbose) {
            $this->_error = mysql_error();
        }

        return $_array;
    }
    
    public function fetch_all() 
    {
        $this->_query->setFetchMode(PDO::FETCH_ASSOC);
        $results = array();
        while($_array = $this->_query->fetch()){  
            foreach($_array as $key=>$val){ 
                if(is_numeric($key)){ 
                    unset($_array[$key]); 
                } 
            }
            $results[] = $_array; 
        }
        
        if(!$_array && $this->_verbose) {
            $this->_error = mysql_error();
        }

        return $results;
    }

    /*
     * Will return the number or rows affected from the query.
     */
    public function num_rows() 
    {
        $num = $this->_query->rowCount();

        if(!$num && $this->_verbose) {
            $this->_error = mysql_error();
        }

        return $num;
    }

    /*
     * If $query_text is blank, 
     * query will be performed on the built query '$this->_buildQuery' stack.
     */
    public function query($queue = '') 
    {
        $queue = ($queue == '') ? $this->_buildQuery : $queue;
        
        $query = $this->connection->query($queue);
        
        if(!$query && $this->_verbose) {
            echo "<h1>MySQL Error:</h1>";
            echo "<p>" . mysql_error() . "</p>";
        }

        $this->_query = $query;
        
        return $this;
    }

	/*
     * Will return the current built query story in $this->_buildQuery stack;
     */
    public function get_query() 
    {
        return $this->_buildQuery;
    }

	/*
     * Will return the current stored error.
     */
    public function get_error() 
    {
        return $this->_error;
    }
    
}
?>
