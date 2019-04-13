<?php 

namespace Kappa;

use \App\Models\Goods;

class Cart
{
	public $cart;

	public $container;

	public function __construct($cart, $container)
	{
		$this->cart = $cart;
		$this->container = $container;
	}

	public function add($id, $quantity, $size)
	{
		
		$product = Goods::find($id);
		if ($product->language_id != $this->user->language_id){
			$this->flash->addMessage('header', 'error');
			return;
		}
		
		$item = array();
		if(in_array($size, ['s', 'm', 'l', 'xl'])){
			$item['size'] = $size;
		} else {
			$item['size'] = 'm';
		}
		
		$this->cart->add($id, $quantity, $item);
		$this->cart->update();
		$this->flash->addMessage('header', 'success');
	}
	public function remove($id)
	{
		$this->cart->remove($id);
		$this->cart->update();

	}

	public function isEmpty()
	{
		return empty($this->cart->all());

	}
	public function __call($method, $args)
	{
		return $this->cart->$method($args);
	}

	public function __get($prop)
	{
		return $this->container->$prop;
	}
}