<?php
include __DIR__ . '/../vendor/autoload.php';

// all dates in UTC timezone
date_default_timezone_set("UTC");

// setup database
\RedBeanPHP\R::setup('sqlite:./db.sqlite');

$handlers = handler\Handlers::get();
$handlers->add(new handler\http\HttpStatusHandler());
$handlers->add(new handler\json\JsonHandler());

$router = new router\Router();
$resource = new \rest\resource\RestResource('TEST');
$resource->whiteList('GET', 'OPTIONS');
$routes = new \rest\route\ResourceRoute($resource, $router);

$result = $router->match($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$handler = $handlers->getHandler($result);

if ($handler) {
    $handler->handle($result);
} else {
    $error = new handler\http\HttpStatus(404, '404 Not Found');
    $handler = $handlers->getHandler($error);
    $handler->handle($error);
}
