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


    $view->addExtension(
        new Awurth\SlimValidation\ValidatorExtension($container['validator'])
    );

    
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
    $cart = new \Vladk23cm\Cart\Cart('cart', new Vladk23cm\Cart\Storage\SessionStore);
    $cart->restore(); 
	return $cart;
};

$container['config'] = \App\Models\Config::getConfig();
$container['common'] = function ($container) {
    return new \App\Controllers\CommonController($container);
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

$container['LanguageController'] = function ($container) {
    return new \App\Controllers\LanguageController($container);
};

$container['lang'] = function ($container) {
    return new \Kappa\PageTranslator( ROOT . '\app\Language', $container->user->getParameter('language')->short);
};

$container['validator'] = function () {
    return new Awurth\SlimValidation\Validator();
};
$container['user'] = function () {
    return new Kappa\User;
};
require ROOT . '/app/routes.php';

$app->run();

