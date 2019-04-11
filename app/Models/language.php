<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class Language extends Model
{
	

	public function user()
	{
		return $this->hasMany('App\Models\User');
	}

	public function goods()
	{
		return $this->hasMany('\App\Models\Goods');
	}
	public function categories()
	{
		return $this->hasMany('\App\Models\Categorie');
	}
}