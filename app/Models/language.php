<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Language extends Model
{

	public function user()
	{
		return $this->hasMany('App\Models\User');
	}
}