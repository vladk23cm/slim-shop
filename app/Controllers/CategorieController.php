<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Categorie;

class CategorieController extends Controller
{
	public function index($req, $res, $args)
	{
		$data = $this->data();

		$data['categories'] = Categorie::all();

		return $res->withJson($categories->toArray());
	}

	public function single($req, $res, $args)
	{
		$data = $this->data();

		$cat = Categorie::find($args['id']);
		
		if (!$cat) {
			return  new \Slim\Http\Response(404);
		}

		$data['goods'] = $cat->goods->toArray();

		$cat_array = $cat->toArray();

		return $this->view->render($res, 'shop.html', $data);
		
	}
}