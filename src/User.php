<?php

namespace Kappa;

use App\Models\User as Model;
use App\Models\Language;
class User
{
	public static $user;

	public static $instance = null;

	public function getInstance()
	{
		if (self::$instance === null ){
			self::$instance = self::getUser();
		}
		return self::$instance;
	}
	public function getIp()
	{
		$ipaddress = '';
    	if (getenv('HTTP_CLIENT_IP'))
        	$ipaddress = getenv('HTTP_CLIENT_IP');
    	else if(getenv('HTTP_X_FORWARDED_FOR'))
        	$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    	else if(getenv('HTTP_X_FORWARDED'))
        	$ipaddress = getenv('HTTP_X_FORWARDED');
    	else if(getenv('HTTP_FORWARDED_FOR'))
       	 	$ipaddress = getenv('HTTP_FORWARDED_FOR');
    	else if(getenv('HTTP_FORWARDED'))
        	$ipaddress = getenv('HTTP_FORWARDED');
    	else if(getenv('REMOTE_ADDR'))
        	$ipaddress = getenv('REMOTE_ADDR');
    	else
        	$ipaddress = 'UNKNOWN';
 
    	return $ipaddress;
	}
	private function __construct($user)
	{
		$this->user = $user;
	}
	private function getUser()
	{
		$ip = self::getIp();
		$user = Model::firstOrCreate(['ip' => $ip]);
		$instance = new self($user);
		return $instance;
	}

	public function changeLang($id)
	{
		$language = Language::find($id);
		
		if ($language) {
			$this->user
				->update([
					'language_id' => $language->id
				]);
			$this->user->save();
		}
	}

	public function __get($name)
	{
		return $this->user->$name;
	}
}