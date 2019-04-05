<?php 
//
//file for creating routes
//

$app->get('/shop', 'GoodsController:index')->setName('shop');
$app->get('/goods/{id:[0-9]+}', 'GoodsController:single');

$app->get('/categories/', 'CategorieController:index');
$app->get('/categorie/{id:[0-9]+}', 'CategorieController:single')->setName('categorie');

$app->post('/api/cart/add/{id:[0-9]+}', 'CartController:add');
$app->get('/api/cart/remove/{id:[0-9]+}', 'CartController:remove');
$app->get('/api/cart/all', 'CartController:all');
$app->get('/api/cart/count', 'CartController:count');
$app->get('/cart', 'CartController:index')->setName('cart');
// checkout
$app->get('/checkout', 'CheckoutController:index');
$app->get('/checkout/store', 'CheckoutController:store');
// languages
$app->get('/change-language/{id:[0-9]+}', 'LanguageController:change')->setName('language-changer');
$app->get('/', 'IndexController:index');
// $app->get('{vue:[\/\w\.-]*}', function ($req, $res, $prop) {
// 	return ;
// });

