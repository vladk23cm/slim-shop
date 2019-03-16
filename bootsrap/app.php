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

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('app/View/', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
	return $capsule;
};

$container['cart'] = function ($container) {
	return new \Vladk23cm\Cart\Cart('cart', new Vladk23cm\Cart\Storage\SessionStore);
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
$container['CategorieController'] = function ($container) {
	return new \App\Controllers\CategorieController($container);
};
$container['CheckoutController'] = function ($container) {
    return new \App\Controllers\CheckoutController($container);
};


$container['validator'] = function () {
    return new Awurth\SlimValidation\Validator();
};

require ROOT . '/app/routes.php';

$app->run();

