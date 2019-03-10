<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
	protected $table = 'categorie';
	
	public function goods()
	{
		return $this->hasMany('App\Models\Goods');
	}
}