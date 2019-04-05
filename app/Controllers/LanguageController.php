<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Language;
use \App\Models\Ip;
use \App\Models\User;


class LanguageController extends Controller
{

	public function change($req, $res, $args)
	{
		$language = Language::find($args['id']);
		if ($language) {
			User::find($this->user->getParameter('id'))
				->update([
					'language_id' => $language->id
				]);


			return $res->withRedirect($_SERVER['HTTP_REFERER'], 301);
		}

	}

	public function getSwitcher()
	{
		$data = [];
		$data['languages'] = Language::all()->toArray();
		$data['current'] = $this->user->getParameter('language_id');
		return $this->render('switcher', $data);
	}	
}