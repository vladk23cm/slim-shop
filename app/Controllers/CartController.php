<?php 

namespace App\Controllers;


use \App\Models\Goods;


class CartController extends Controller
{
	
	public function add($req, $res, $prop)
	{
		$post = $req->getParsedBody();
		$this->cart->add($prop['id'], $post['quantity'], $post['size']);
		return $res->withRedirect($_SERVER['HTTP_REFERER'], 301);
	}

	public function remove($req, $res, $prop)
	{
		$this->cart->remove($prop['id']);

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
		$data = $this->data();
		$data['lang'] = $this->lang->translate('cart'); 
		$cart = $this->cart->all();
		$goods = Goods::find(array_keys($cart));
		if ($goods) {
			$goods = array_map( function ($arr) use ($cart){

				$quantity = $cart[$arr['id']]['quantity'];
				$arr['total'] = $quantity * $arr['price'];
				$arr['quantity'] = $quantity;
				$arr['size'] = $cart[$arr['id']]['size'];
				return $arr;
			}, $goods->toArray());
		}
		$data['goods'] = $goods;
		$data['total_price'] = array_sum(array_map( function ($arr) {
      		return $arr['price'] * $arr['quantity'];
      	}, $data['goods']));
		$data['header'] = $this->common->getHeader($data['lang']['title']);
		$data['footer'] = $this->common->getFooter();
		return $this->view->render($res, 'cart.html', $data);
	}

	public function getCart()
	{
		$data = [];
		$data['quantity'] = $this->cart->count();
		return $this->render('cart', $data);
	}

	public function flush()
	{
		$this->cart->flush();
	}

} 