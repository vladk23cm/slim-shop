<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Language;
use \App\Models\Ip;

use \Kappa\User;


class LanguageController extends Controller
{

	public function change($req, $res, $args)
	{
		global $user;
		$this->user->changeLang($args['id']);
		$this->cart->flush();					
		return $res->withRedirect('/', 301);
		

	}

	public function getSwitcher()
	{
		$data = [];
		$data['languages'] = Language::all()->toArray();
		$data['current'] = $this->user->language_id;
		return $this->render('switcher', $data);
	}	
}