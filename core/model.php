<?php

/**
 * Swift Database Connector
 *
 * @Author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 * Version 0.0.1
 */
include 'dblayer.php';

class Model {

    /**
     * The instance of Database
     *
     * @var Database
     */
    public $db;

	/**
     * The structure of the database
     *
     * @var array
     */
    public $db_structure;
    /**
     * Array of custom table indexes
     *
     * @var array
     */
    public $table_index;

	public function __construct()
	{
		global $config;

        $this->db = new DbLayer($config);
        if(!$this->db->init()) throw new Exception($this->db->get_error());
		//$this->db_structure = $this->map_db($config['db_name']);
		$this->table_index = array();

	}

    /**
     * Add a custom index (usually primary key) for a table
     *
     * @param string $table Name of the table
     * @param string $field Name of the index field
     * @access public
     */
    public function set_table_index($table, $field)
    {
        $this->table_index[$table] = $field;
    }

    /**
     * Map the stucture of the MySQL db to an array
     *
     * @param string $database Name of the database
     * @return array Returns array of db structure
     * @access public
     */
    public function map_db($database)
    {
        // Map db structure to array
        $tables_arr = array();
        $this->db->query('SHOW TABLES FROM '. $database);
        while($table = $this->db->fetch_array()){
            if(isset($table['Tables_in_'. $database])){
                $table_name = $table['Tables_in_'. $database];
                $tables_arr[$table_name] = array();
            }
        }
        foreach($tables_arr as $table_name=>$val){
            $this->db->query('SHOW COLUMNS FROM '. $table_name);
            $fields = $this->db->fetch_all();
            $tables_arr[$table_name] = $fields;
        }
        return $tables_arr;
    }
    
}
?>
