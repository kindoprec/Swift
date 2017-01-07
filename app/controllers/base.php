<?php

class Base extends Controller {
	
	function index()
	{
		$template = $this->loadView('index');
		$template->setPageTitle('Home | '.SITE_NAME);
		
		// Get all users
		$user = $this->loadModel('user');
		$eUsers = $user->getUsers();

		// Get one user
		$uid = 1;
		$user = $user->getUser($uid);
		$template->set(compact('eUsers', 'user'));
		
		$template->render();
	}
    
}

?>
