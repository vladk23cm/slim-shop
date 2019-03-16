<?php 
//
//file for creating routes
//

$app->get('/shop', 'GoodsController:index');
$app->get('/goods/{id:[0-9]+}', 'GoodsController:single');

$app->get('/categories/', 'CategorieController:index');
$app->get('/categorie/{id:[0-9]+}', 'CategorieController:single');

$app->post('/api/cart/add/{id:[0-9]+}', 'CartController:add');
$app->get('/api/cart/remove/{id:[0-9]+}', 'CartController:remove');
$app->get('/api/cart/all', 'CartController:all');
$app->get('/api/cart/count', 'CartController:count');
$app->get('/cart', 'CartController:index');
// checkout
$app->get('/checkout', 'CheckoutController:index');
$app->get('/checkout/store', 'CheckoutController:store');

$app->get('/', 'IndexController:index');
// $app->get('{vue:[\/\w\.-]*}', function ($req, $res, $prop) {
// 	return ;
// });

