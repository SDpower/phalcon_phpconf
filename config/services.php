<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$di = new FactoryDefault();
if (APP_ENV == "development") {
//Register Debug
    $debug = new \Phalcon\Debug();
    $debug->listen();
    $di['debug'] = $debug;
}
/**
 * Sets the view component
 */
$di->set('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->disableLevel(array(
        Phalcon\Mvc\View::LEVEL_LAYOUT => true,
        Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT => true
    ));
    return $view;
},true);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
},true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di['db'] = function () use ($config) {
    return new DbAdapter(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ));
};

$di['router'] = function() {

    //Use the annotations router
    $router = new \Phalcon\Mvc\Router\Annotations(false);

    $router->addResource('Index', '/');

    return $router;
};
