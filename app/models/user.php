<?php

class User extends Model {
	
	public function getUser($id)
	{
		$id = $this->_escstr($id);
		$result = $this->query('SELECT * FROM user WHERE id="'. $id .'"');
		return $result;
	}

}

?>
