<?php

class User extends Model {
	
	public function getUser($id)
	{
		$result = $this->db->select('*')->from('user')->query();
		return $result->fetch_object();
	}
	//->where('id', $id)

}

?>
