<?php

require ROOT . '/vendor/autoload.php';

$app = new \Slim\App(array(
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
	    	'driver' => 'mysql',
	    	'host' => 'localhost',
	    	'database' => 'vladk23cm',
	    	'username' => 'root',
	    	'password' => '',
	    	'charset' => 'utf8',
	    	'collation' => 'utf8_unicode_ci'
    	]
    ], 
));

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
	return $capsule;
};

$container['cart'] = function ($container) {
	return new \Cart\Cart('cart', new \Cart\Storage\CookieStore);
};

$container['IndexController'] = function ($container) {
	return new \App\Controllers\IndexController($container);
};
$container['GoodsController'] = function ($container) {
	return new \App\Controllers\GoodsController($container);
};
$container['CartController'] = function ($container) {
	return new \App\Controllers\CartController($container);
};

require ROOT . '/app/routes.php';

$app->run();

