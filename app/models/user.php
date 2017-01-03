<?php

class User extends Model {
	
	public function getUser($id)
	{
		$result = $this->db->select('*')->from('user')->query();
		return $result->fetch_array();
	}
	//->where('id', $id)

}

?>
