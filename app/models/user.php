<?php

class User extends Model {
	
	public function getUser($id)
	{
		$result = $this->db->select('*')
						->from('user')
			            ->where('id', $id)
			            ->query();
		return $result;
	}

}

?>
