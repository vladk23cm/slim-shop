<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \App\Models\Language;

class User extends Model
{
	public $fillable = array('ip', 'language_id');

	public function language()
	{
		return $this->belongsTo('App\Models\Language');
	}

}