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
        'debug' => true,
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    
    $view->addExtension(new \Twig\Extension\DebugExtension());


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
$user = \Kappa\User::getInstance();
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
$container['cart'] = function ($container) {
    $cart = new \Vladk23cm\Cart\Cart('cart', new Vladk23cm\Cart\Storage\SessionStore);
    $cart->restore(); 
    $rc = new \Kappa\Cart($cart, $container);
    return $rc;
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

$container['lang'] = function ($container) use ($user) {
    return new \Kappa\PageTranslator( ROOT . '\app\Language', $user->language->short);
};

$container['validator'] = function ($container) {
    $translations = $container->lang->translate('validator');
    return new Awurth\SlimValidation\Validator(true, $translations);
};
$container['user'] = function () use ($user) {
    return $user;
};
$container['config'] = function () {
    return \App\Models\Config::getConfig();
};
require ROOT . '/app/routes.php';

$app->run();

