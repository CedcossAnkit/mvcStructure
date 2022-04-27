<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream as newstream;
use Phalcon\Config;
use Phalcon\Config\ConfigFactory;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as eventManager;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Mvc\Router;




define("BASE_PATH", dirname(__DIR__));
define("APP_PATH", BASE_PATH . "/app");

// die(APP_PATH);

$loader = new Loader();
$container = new FactoryDefault();
$router = new Router();

$loader->registerDirs(
    [
        APP_PATH . "/controllers",
        APP_PATH . "/models/"
    ]
);

$loader->registerNamespaces(
    [
        "App\Components" => APP_PATH . "/components",
        "App\Listener" => APP_PATH . "/Listener"
    ]
);


$loader->register();


//logger
$container->set(
    'logger',
    function () {
        $adapter = new newstream(APP_PATH . "/log/main.log");
        $logger = new Logger("messages", [
            "main" => $adapter
        ]);

        return $logger;
    }

);

//config
$container->set(
    'config',
    function () {
        $filename = APP_PATH . "/etc/config.php";
        $configLoad = new ConfigFactory();
        return $configLoad->newInstance('php', $filename);
    }
);
$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

//event manager
$eventmanger = new eventManager();
$container->set(
    'eventmanager',
    $eventmanger
);

$eventmanger->attach(
    'eventhandler',
    new App\Listener\Eventhandler()
);

//Session
$container->set(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(["savePath" => "/tmp"]);
        $session->setAdapter($files)->start();
        return $session;
    }
);

//router

$router->add(
    '/login',
    [
        'controller' => 'test',
        'action'     => 'test',
    ]
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
    $router->handle(
        $_SERVER["REQUEST_URI"]
    );
    $response->send();
} catch (Exception $e) {
    echo "Exception Occour" . $e->getMessage();
}
