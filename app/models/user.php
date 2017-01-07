<?php

class User extends Model {
	
	public function getUsers()
	{
		$result = $this->db->select('*')->from('user')
		    ->query();
		return $result->fetch_all();
	}

	public function getUser($id)
	{
		$result = $this->db->select('*')->from('user')
		    ->where('id', $id)
		    ->limit(1)
		    ->query();
		return $result->fetch_array();
	}

}

?>
