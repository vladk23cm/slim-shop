<?php 

namespace App\Controllers;

use \Cart\CartItem;
use \App\Controllers\Controller;
use \App\Models\Goods;

class CartController extends Controller
{
	public function __construct($container)
	{
		parent::__construct($container);
		try {
			$this->cart->restore();
		} catch (Cart\CartRestoreException $e) {
			
		}
	}
	public function add($req, $res, $prop)
	{
		Goods::find($prop['id']);
		
	}
	public function remove($req, $res)
	{
		$this->cart->remove(1);
	}
	public function all($req, $res)
	{
		return $res->withJson($this->cart->all());
		
		
	}
} 