<?php 
//
//file for creating routes
//

$app->get('/shop', 'GoodsController:index')->setName('shop');
$app->get('/goods/{slug}', 'GoodsController:single')->setName('product');

$app->get('/categories/', 'CategorieController:index');
$app->get('/categorie/{slug}', 'CategorieController:single')->setName('categorie');

$app->post('/api/cart/add/{id:[0-9]+}', 'CartController:add');
$app->get('/api/cart/remove/{id:[0-9]+}', 'CartController:remove');
$app->get('/api/cart/all', 'CartController:all');
$app->get('/api/cart/count', 'CartController:count');
$app->get('/api/cart/flush', 'CartController:flush');
$app->get('/cart', 'CartController:index')->setName('cart');
// checkout
$app->get('/checkout', 'CheckoutController:index');
$app->post('/checkout', 'CheckoutController:index');
// languages
$app->get('/change-language/{id:[0-9]+}', 'LanguageController:change')->setName('language-changer');
$app->get('/', 'IndexController:index');
// $app->get('{vue:[\/\w\.-]*}', function ($req, $res, $prop) {
// 	return ;
// });

