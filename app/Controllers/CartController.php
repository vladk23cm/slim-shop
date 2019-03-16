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
		$post = $req->getParsedBody();
		$item = array();
		if(in_array($post['size'], ['s', 'm', 'l', 'xl'])){
			$item['size'] = $post['size'];
		} else {
			$item['size'] = 'm';
		}
		$this->cart->add($prop['id'], $post['quantity'], $item);
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
			$arr['quantity'] = $cart[$arr['id']]['quantity'];
			return $arr;
		}, $goods);

		return $res->withJson($result);	
	}

	public function index($req, $res)
	{
	
		
		$result = Goods::getCartItems($this->cart->all());
		print_r($result);
		return $this->view->render($res, 'cart.html', [
      		'goods' => $result
    	]);
	}

	public function count($req, $res)
	{
		$quantity = array_map(function ($arr) {
			return $arr['quantity'];
		}, $this->cart->all());
		$sum = array_sum($quantity);
		return $res->getBody()->write($sum);	
	}
} 