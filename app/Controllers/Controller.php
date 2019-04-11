<?php 

namespace App\Controllers;



class Controller
{
	protected $container;

	private $data;

	private $twigEnvironment;

	public function __construct($container)
	{
		$this->container = $container;
		$this->data = [];
		$this->twigEnvironment = $container->view->getEnvironment();
	}

	public function __get($prop)
	{
		return $this->container->$prop;
	}
	// Костыль ЫЫЫ
	public function data()
	{
      	
      	
      	
      	return $this->data;
	}
	// renders a html template from common folder
	// @return String
	public function render($name, $data)
	{
		$template = $this->twigEnvironment->load('common/' . $name . '.html');
		
		return $template->render($data);
	}
}