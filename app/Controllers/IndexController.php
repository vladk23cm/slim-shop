<?php 

namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Goods;

class IndexController extends Controller
{

	public function form($req, $res)
	{
		return $this->view->render($res, 'admin.html');
	}
	public function add($req, $res)
	{
		$post = $req->getParsedBody();
		$product = Goods::create();
		$product->title = $post['title'];
		$product->description = $post['desc'];
		$product->categorie_id = $post['categorie'];
		$product->language_id = $post['lang'];
		$product->price = $post['price'];
		$product->slug = $post['slug'];
		$product->image = $post['image'];
		$product->save();
		
	}
	public function index($req, $res, $args)
	{
		$data = $this->data();
		$data['lang'] = $this->lang->translate('home'); 	
		$data['header'] = $this->common->getHeader($data['lang']['title']);
		$data['footer'] = $this->common->getFooter();
		$data['content'][] = $this->common->getCategories();
		$data['content'][] = $this->common->getFeatured();

		return $this->view->render($res, 'index.html', $data);
	}
}