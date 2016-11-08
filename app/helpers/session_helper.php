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

}

?>