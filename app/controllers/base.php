<?php

class Base extends Controller {
	
	function index()
	{
		$template = $this->loadView('index');
		$template->setPageTitle('Home');
		
		$user = $this->loadModel('user');
		$eUser = $user->getUser(1);
		$template->set(compact('eUser'));
		
		$template->render();
	}
    
}

?>
