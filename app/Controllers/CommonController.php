<?php
namespace App\Controllers;

use \App\Controllers\Controller;

use \App\Models\Config;

class CommonController extends Controller
{

	public function getHeader($title = '')
	{
		$data = [];
		$data['cart'] = $this->cart->count();
		$data['lang'] = $this->lang->translate('common/header');
		$data['left'][] = $this->container->get('LanguageController')->getSwitcher();
		$data['right'][] = $this->container->get('CartController')->getCart();
		$data['messages'] = $this->flash->getMessages();
		$data['menu'] = $this->getMenu();
		$data['config'] = $this->config;
		$data['title'] = $title . ' - ' . $data['config']['name'];
		
		return $this->render('header', $data);	
	}

	public function getFooter()
	{
		$data = [];
		$data['config'] = $this->config;
		$data['lang'] = $this->lang->translate('common/footer');
		return $this->render('footer', $data);	
	}
	
	public function getMenu()
	{
		$categories = $this->user->language->categories;
		$data = [];
		$data['lang'] = $this->lang->translate('common/menu');
		$data['categories'] = $categories;
		return $this->render('menu', $data);
	}

	public function getFeatured()
	{
		$products = $this->user->language->goods->shuffle()->take(6);
		$data = [];
		$data['lang'] = $this->lang->translate('common/featured');
		$data['goods'] = $products;
		return $this->render('featured', $data);
	}

	public function getCategories()
	{
		$categories = $this->user->language->categories->take(3); 
		
		$data = [];
		$data['lang'] = $this->lang->translate('common/categories');
		$data['categories'] = $categories->toArray();
		return $this->render('categories', $data);
	}
}