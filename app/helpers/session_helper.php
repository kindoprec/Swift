<?php

class Session_helper {

	public function get($key)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}

		return null;
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	function destroy()
	{
		session_destroy();
	}

	//
	public function is_loggedin()
    {
    	if($this->get('UserID')){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function sessid()
    {
    	return $_SESSION['UserID'];
    }

}

?>