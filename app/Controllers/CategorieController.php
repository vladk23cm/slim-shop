<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Categorie;

class CategorieController extends Controller
{
	public function index($req, $res, $args)
	{
		return $res->withJson($cat->toArray());
	}

	public function single($req, $res, $args)
	{
		$cat = Categorie::find($args['id']);
		$cat_array = $cat->toArray();
		return $this->view->render($res, 'shop.html', [
        	'goods' => $cat->goods->toArray(),
        	'title' => $cat_array['name']
    	]);
		
	}
}