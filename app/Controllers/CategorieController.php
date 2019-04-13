<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Categorie;
use \App\Models\Goods;

class CategorieController extends Controller
{
	public function index($req, $res, $args)
	{
		$data = $this->data();

		$data['categories'] = Categorie::all();
		$data['header'] = $this->common->getHeader();
		$data['footer'] = $this->common->getFooter();
		return $res->withJson($categories->toArray());
	}

	public function single($req, $res, $args)
	{
		$user = $this->user;
		$data = $this->data();
		
		$categorie = Categorie::where('slug', $args['slug'])->first();
		if ($user->language_id != $categorie->language_id) {
			$this->user->changeLang($categorie->language_id, $user->language_id);
		}
		$goods = $categorie->goods;
		$data['goods'] = $goods;

		$data['header'] = $this->common->getHeader($categorie->name);
		$data['footer'] = $this->common->getFooter();

		return $this->view->render($res, 'shop.html', $data);
		
	}
}