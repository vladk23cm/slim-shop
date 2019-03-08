<?php
namespace App\Controllers;

use \App\Controllers\Controller;
use \App\Models\Goods;

class GoodsController extends Controller
{
	public function index($req, $res, $args)
	{
		print_r(Goods::all());
		return $res->getBody()->write('Kappa123');
	}
}