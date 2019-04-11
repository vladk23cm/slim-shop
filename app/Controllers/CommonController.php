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
		$data['lang'] = $this->lang->translate('common/header');
		$data['left'][] = $this->container->get('LanguageController')->getSwitcher();
		$data['right'][] = $this->container->get('CartController')->getCart();
		$data['messages'] = $this->flash->getMessages();
		$data['menu'] = $this->getMenu();
		return $this->render('header', $data);	
	}

	public function getFooter()
	{
		$data = [];
		$data['config'] = Config::getConfig();
		$data['lang'] = $this->lang->translate('common/footer');
		return $this->render('footer', $data);	
	}
	
	public function getMenu()
	{
		$categories = $this->user->language->categories->toArray();
		$data = [];
		$data['lang'] = $this->lang->translate('common/menu');
		$data['categories'] = $categories;
		return $this->render('menu', $data);
	}
}