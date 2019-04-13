<?php 

namespace App\Controllers;

use \App\Controllers\Controller;
use Respect\Validation\Validator as V;
use \App\Models\Goods;

class CheckoutController extends Controller
{
	public function index($req, $res, $args)
	{
		
		if ($this->cart->isEmpty()) {
			return $res->withRedirect('/');
		}
		$data = $this->data();
		if ($req->isPost()) {
			
        	$this->validator->validate($req, [
	            'first_name' 		=> V::notBlank()->length(2, 25)->noWhitespace(),
	    		'last_name' 		=> V::notBlank()->length(2, 25)->noWhitespace(),
	    		'street_address'    => V::notBlank()->length(2, 25),
	    		'house_address'    	=> V::notBlank()->length(1, 25)->noWhitespace()->numeric(),
	    		'flat_address'    	=> V::length(0, 25),
	    		'town'   			=> V::notBlank()->length(2, 25),
	    		'zip'    			=> V::notBlank()->numeric()->length(2, 25),
	    		'email'    			=> V::notBlank()->length(6, 254)->email(),
	    		'phone'    			=> V::notBlank()->length(9, 15)->numeric(),
				'order_notes'    	=> V::length(0, 200),
   			 ]);
        
        	if ($this->validator->isValid()) {
            	return $res->withRedirect($this->router->pathFor('thanks'));
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
      	$data['lang'] = $this->lang->translate('checkout');
		$data['header'] = $this->common->getHeader($data['lang']['title']);
		$data['footer'] = $this->common->getFooter();
      	
		return $this->view->render($res, 'checkout.html', $data);
	}
	
	public function thanks($req, $res)
	{
		$data = $this->data();
		$data['lang'] = $this->lang->translate('thanks');
		$data['header'] = $this->common->getHeader($data['lang']['title']);
		$data['footer'] = $this->common->getFooter();

		return $this->view->render($res, 'thanks.html', $data);
	}
}