<?php 

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	protected $table = 'config';

	public static $config;

	public function getConfig()
	{
		$config = self::all()->toArray();

		$result = [];

		foreach ($config as $value) {
			$result[$value['title']] = $value['value'];
		}

		return $result;
	}
}