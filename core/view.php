<?php

class View extends Swift {

	private $pageVars = array();
	private $template;

	# Encapsulate Page Vars
	private $pageTitle = "Welcome to Swift";
    private $pageDescription = "Swift is a framework from your friends at Swiftly(http://swiftlyweb.com)";
    private $pageKeywords = array();

	public function __construct($template)
	{
		$this->template = APP_DIR .'views/'. $template .'.php';
	}

	public function set2($var, $val)
	{
		$this->pageVars[$var] = $val;
	}

	public function set($var)
	{
		# Use loops to avoid manually setting for every needed var
		foreach ($var as $field => $value) {
            $this->pageVars[$field] = $value; 
        }
	}

	public function getPageTitle() {
        return $this->pageTitle;
    }

    public function setPageTitle($pageTitle) 
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    public function getPageDescription() 
    {
        return $this->pageDescription;
    }

    public function setPageDescription($pageDescription) 
    {
        $this->pageDescription = $pageDescription;
        return $this;
    }

    public function getPageKeywords() 
    {
        return $this->pageKeywords;
    }

    public function setPageKeywords($pageKeywords) 
    {
        $this->pageKeywords = $pageKeywords;
        return $this;
    }

	public function render()
	{
		extract($this->pageVars);
		ob_start();
		require($this->template);
		echo ob_get_clean();
	}
    
}

?>