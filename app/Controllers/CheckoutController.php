<?php 

namespace App\Controllers;

use \App\Controllers\Controller;
use Respect\Validation\Validator as V;
use \App\Models\Goods;

class CheckoutController extends Controller
{
	public function index($req, $res, $args)
	{
		$cart = $this->cart->all();
		
		$goods = Goods::find(array_keys($cart))->toArray();
		$result = array_map(function ($arr) use ($cart) {
			$arr['quantity'] = $cart[$arr['id']]['quantity'];
			return $arr;
		}, $goods);


		return $this->view->render($res, 'checkout.html', [
        	
    	]);
	}

	public function store($req, $res, $args)
	{
		$validator = $container->validator->validate($request, [
    		'get_or_post_parameter_name' => V::length(6, 25)->alnum('_')->noWhitespace(),
    		// ...
		]);

		if ($validator->isValid()) {
    		// Do something...
		} else {
    		$errors = $validator->getErrors();
		}	
	}
}