<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Goods;

class GoodsController extends Controller
{
	public function index($req, $res, $args)
	{

		return $this->view->render($res, 'shop.html', [
        	'goods' => Goods::all()->toArray(),
        	'title' => 'Все товары'
    	]);
	}

	public function single($req, $res, $args)
	{
		return $this->view->render($res, 'single.html', [
        	'name' => $args['name']
    	]);
		return $res->withJson(Goods::find($args['id'])->toArray());
	}
}