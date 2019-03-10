<?php 

namespace App\Controllers;

use \App\Controllers\Controller;


class IndexController extends Controller
{
	public function index($req, $res, $args)
	{
		return $this->view->render($res, 'index.html', [
        	'name' => 'batya'
    	]);
	}
}