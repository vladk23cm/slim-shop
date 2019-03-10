<?php 

namespace App\Controllers;


use \App\Models\Goods;

class CartController extends Controller
{
	public function __construct($container)
	{
		parent::__construct($container);
		
		$this->cart->restore();	
	}

	public function add($req, $res, $prop)
	{
		$this->cart->add($prop['id'], $prop['quality']);
		$this->cart->update();
		return $res->withRedirect($_SERVER['HTTP_REFERER'], 301);
	}

	public function remove($req, $res, $prop)
	{
		$this->cart->remove($prop['id']);
		$this->cart->update();
		return $res->withRedirect($_SERVER['HTTP_REFERER'], 301);
	}

	public function all($req, $res)
	{
		$cart = $this->cart->all();
		
		$goods = Goods::find(array_keys($cart))->toArray();
		$result = array_map(function ($arr) use ($cart) {
			$arr['quality'] = $cart[$arr['id']];
			return $arr;
		}, $goods);

		return $res->withJson($result);	
	}

	public function index($req, $res)
	{
		$cart = $this->cart->all();
		
		$goods = Goods::find(array_keys($cart))->toArray();
		$result = array_map(function ($arr) use ($cart) {
			$arr['quality'] = $cart[$arr['id']];
			$arr['total'] = $cart[$arr['id']] * $arr['price'];
			return $arr;
		}, $goods);

		return $this->view->render($res, 'cart.html', [
        	'goods' => $result
    	]);
	}

	public function count($req, $res)
	{
		$sum = array_sum($this->cart->all());
		return $res->getBody()->write($sum);	
	}
} 