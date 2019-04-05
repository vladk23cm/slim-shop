<?php 

namespace App\Controllers;

use \App\Controllers\Controller;


class IndexController extends Controller
{
	public function index($req, $res, $args)
	{
		$data = $this->data(); 	
		
		return $this->view->render($res, 'index.html', $data);
	}
}