<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
	protected $table = 'goods';

	public function categorie()
	{
		return $this->belongsTo('App\Models\Categorie');
	}

	public function getCartItems($cart)
	{
		$goods = Goods::find(array_keys($cart))->toArray();
		$result = array_map(function ($arr) use ($cart) {
			$arr['quantity'] = $cart[$arr['id']]['quantity'];
			$arr['total'] = $cart[$arr['id']]['quantity'] * $arr['price'];
			$arr['size'] =  $cart[$arr['id']]['size'];
			return $arr;
		}, $goods);
		return $result;
	}
}