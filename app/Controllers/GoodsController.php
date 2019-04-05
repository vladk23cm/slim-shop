<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Goods;

class GoodsController extends Controller
{
	public function index($req, $res, $args)
	{
		$data = $this->data(); 	
		
      	$data['goods'] = Goods::all()->toArray();
		return $this->view->render($res, 'shop.html', $data);
	}

	public function single($req, $res, $args)
	{
		$data = $this->data();
		$item = Goods::find($args['id']);
		if (!$item) {
			return  new \Slim\Http\Response(404);
		}
      	$data['item'] = $item->toArray();
		return $this->view->render($res, 'single.html', $data);
		
	}
}