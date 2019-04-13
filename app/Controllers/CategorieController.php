<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Categorie;
use \App\Models\Goods;

class CategorieController extends Controller
{
	public function random($req, $res, $args)
	{
		$data = $this->data();
		$slug = $this->user->language->categories->shuffle()->first()->slug;
		$url = $this->router->pathFor('categorie',['slug'=>$slug]);
		
		return $res->withRedirect($url);
		
	}

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
		
		$categorie = $this->user->language->categories->where('slug', $args['slug'])->first();
		
		if (!$categorie) {
			return $res->withStatus(404)
            	->withHeader('Content-Type', 'text/html')
            	->write('Page not found');
		}
		if ($user->language_id != $categorie->language_id) {
			$this->user->changeLang($categorie->language_id, $user->language_id);
		}
		$goods = $categorie->goods->shuffle();
		$data['goods'] = $goods;

		$data['header'] = $this->common->getHeader($categorie->name);
		$data['footer'] = $this->common->getFooter();

		return $this->view->render($res, 'shop.html', $data);
		
	}
}