<?php
namespace App\Controllers;

use \App\Controllers\Controller;

use \App\Models\Config;

class CommonController extends Controller
{

	public function getHeader()
	{
		$data = [];
		$data['cart'] = $this->cart->count();
		$data['lang'] = $this->lang->translate('header');
		$data['right'][] = $this->container->get('LanguageController')->getSwitcher();
		$data['right'][] = $this->container->get('CartController')->getCart();
		return $this->render('header', $data);	
	}

	public function getFooter()
	{
		$data = [];
		$data['config'] = Config::getConfig();
		$data['lang'] = $this->lang->translate('footer');
		return $this->render('footer', $data);	
	}
	
}