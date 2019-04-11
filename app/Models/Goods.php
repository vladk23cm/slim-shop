<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \App\Models\Translation;

class Goods extends Model
{
	protected $table = 'goods';

	
	public function categorie()
	{
		return $this->belongsTo('App\Models\Categorie');
	}

	public function language()
	{
		return $this->belongsTo('\App\Models\Language');
	}

}