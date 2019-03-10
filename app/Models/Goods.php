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
}