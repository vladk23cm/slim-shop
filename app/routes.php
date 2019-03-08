<?php 
//
//file for creating routes
//

$app->get('/api/goods', 'GoodsController:index');

$app->get('/api/cart/add', 'CartController:add');
$app->get('/api/cart/remove', 'CartController:remove');
$app->get('/api/cart/all', 'CartController:all');


$app->get('{vue:[\/\w\.-]*}', function ($req, $res, $prop) {
	return ;
});

