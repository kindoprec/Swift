<?php

/*
 * Swift Core
 * @author Precious Kindo [lilonaony@gmail.com]
 * @Created Nov 2016
 */
class Swift
{
	public $devLog = array();

	public function __construct() {
	}

	public function boot()
	{
		global $config;
	    
	    // Set our defaults
	    $controller = 'base';
	    $action = 'index';
	    $url = '';
		
		# Router Configurations
		// Get request url and script url
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
	    	
		// Get our url path and trim the / of the left and the right
		if($request_url != $script_url)
		{
			$url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
			$url = str_replace('-', '_', $url);
		}

	    
		// Split the url into segments
		$segments = explode('/', $url);
		
		// Do our default checks
		if(isset($segments[0]) && $segments[0] != '') $controller = $segments[0];
		if(isset($segments[1]) && $segments[1] != '') $action = $segments[1];

		// Get our controller file
	    $path = APP_DIR . 'controllers/' . $controller . '.php';
		if(file_exists($path)){
	        require_once($path);
		} else {
	        $controller = 'error';
	        require_once(APP_DIR . 'controllers/' . $controller . '.php');
	        $this->addToLog('User requested an Invalid Page');
		}
	    
	    // Check the action exists
	    if(!method_exists($controller, $action)){
	        $controller = 'error';
	        require_once(APP_DIR . 'controllers/error.php');
	        $action = 'index';
	        $this->addToLog('User has requested an Invalid URL');
	    }
		
		// Create object and call method
		$obj = new $controller;
	    die(call_user_func_array(array($obj, $action), array_slice($segments, 2)));
	}

	public function addToLog2($message) 
	{
		# Log 'eritin that goes thru my parent
        $tracert = debug_backtrace();

        $caller = array_shift($tracert);
        $file = pathinfo($caller['file']);

        $this->devLog[] = array('line' => $caller['line'], 'message' => $message, 'file' => $file['basename']);
    }

    public function addToLog($message) 
	{
		# Log 'eritin that goes thru my parent
		$tracert = debug_backtrace();

        $caller = array_shift($tracert);
        $file = pathinfo($caller['file']);

        $msg = '[Line: ' .$caller['line']. '] | [Message:'. $message. '] | [File name:'. $file['basename'].']';
        file_put_contents(ROOT_DIR .'temp/logs.txt', $msg, FILE_APPEND);
    }

    public function getLogs() 
    {
        return $this->devLog;
    }
}

?>
