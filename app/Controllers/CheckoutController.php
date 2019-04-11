<?php 

namespace App\Controllers;

use \App\Controllers\Controller;
use Respect\Validation\Validator as V;
use \App\Models\Goods;

class CheckoutController extends Controller
{
	public function index($req, $res, $args)
	{
		$data = $this->data();
		
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
		
		$data['header'] = $this->common->getHeader();
		$data['footer'] = $this->common->getFooter();
      	
		return $this->view->render($res, 'checkout.html', $data);
	}

	public function store($req, $res, $args)
	{
		
		$validator = $this->validator->validate($req, [
    		'first_name' 		=> V::length(2, 25)->noWhitespace(),
    		'last_name' 		=> V::length(2, 25)->noWhitespace(),
    		'street_address'    => V::length(2, 25)->noWhitespace(),
    		'house_address'    	=> V::length(2, 25)->noWhitespace(),
    		'flat_address'    	=> V::length(2, 25)->noWhitespace(),
    		'town'   			=> V::length(2, 25)->noWhitespace(),
    		'zip'    			=> V::length(2, 25)->noWhitespace(),
    		'email'    			=> V::length(2, 25)->noWhitespace(),
    		'phone'    			=> V::length(2, 25)->noWhitespace(),
			'order_notes'    	=> V::length(2, 25)->noWhitespace(),

		]);

		if ($validator->isValid()) {
    		// Do something...
		} else {
    		$errors = $validator->getErrors();
		}	
	}
}