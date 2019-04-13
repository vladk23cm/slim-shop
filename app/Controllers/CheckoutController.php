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
		if ($req->isPost()) {
			
        	$this->validator->validate($req, [
	            'first_name' 		=> V::length(2, 25),
	    		'last_name' 		=> V::length(2, 25),
	    		'street_address'    => V::length(2, 25),
	    		'house_address'    	=> V::length(2, 25),
	    		'flat_address'    	=> V::length(2, 25),
	    		'town'   			=> V::length(2, 25),
	    		'zip'    			=> V::length(2, 25),
	    		'email'    			=> V::length(2, 25),
	    		'phone'    			=> V::length(2, 25),
				'order_notes'    	=> V::length(2, 25),
   			 ]);
        
        	if ($this->validator->isValid()) {
            	die;
            }
            
        	
    	}
		
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
		$data['header'] = $this->common->getHeader();
		$data['footer'] = $this->common->getFooter();
      	
		return $this->view->render($res, 'checkout.html', $data);
	}
	
	private function store($req, $res, $args)
	{
		
		
		$validator = $this->validator->validate($req, [
    		

		]);

		if ($validator->isValid()) {
    		
		} else {
    		return $res->withRedirect($_SERVER['HTTP_REFERER'], 301);
		}	
	}
}