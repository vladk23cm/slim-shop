<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Goods;
use \App\Models\Language;
use \Kappa\User;

class GoodsController extends Controller
{
	public function index($req, $res, $args)
	{
		$data = $this->data(); 	
		
      	$data['goods'] = Goods::all()->toArray();
      	$data['header'] = $this->common->getHeader();
		$data['footer'] = $this->common->getFooter();
		return $this->view->render($res, 'shop.html', $data);
	}

	public function single($req, $res, $args)
	{
		$data = $this->data();
		$item = Goods::where('slug', $args['slug'])->first();
		global $user;
		if ($user->language_id != $item->language_id) {
			$this->user->changeLang($item->language_id, $user->language_id);
		}
		if (!$item) {
			return  new \Slim\Http\Response(404);
		}
      	$data['item'] = $item->toArray();
      	$data['header'] = $this->common->getHeader();
		$data['footer'] = $this->common->getFooter();
		return $this->view->render($res, 'single.html', $data);
		
	}
}