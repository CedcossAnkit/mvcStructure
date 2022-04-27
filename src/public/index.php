<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

define("BASE_PATH", dirname(__DIR__));
define("APP_PATH", BASE_PATH . "/app");

// die(APP_PATH);

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers",
        APP_PATH . "/models/"
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);


$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );
    $response->send();
} catch (Exception $e) {
    echo "Exception Occour".$e->getMessage();
}


