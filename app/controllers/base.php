<?php

class Base extends Controller {
	
	function index()
	{
		$template = $this->loadView('index');
		$user = $this->loadModel('user');
		$eUser = $user->getUser(1);
		$template->set(compact('eUser'));
		$template->setPageTitle('Home');
		$template->render();
	}
    
}

?>
