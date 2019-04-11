<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \App\Models\Goods;

class Categorie extends Model
{
	protected $table = 'categorie';
	
	public function goods()
	{
		return $this->hasMany('\App\Models\Goods');
	}

	public function language()
	{
		return $this->belongsTo('\App\Models\Language');
	}
}