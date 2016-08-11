<?php
use RedBeanPHP\R;

include __DIR__ . '/../vendor/autoload.php';

// all dates in UTC timezone
date_default_timezone_set("UTC");

// setup database
R::setup('sqlite:./db.sqlite');

$handlers = handler\Handlers::get();
$handlers->add(new handler\http\HttpStatusHandler());
$handlers->add(new handler\json\JsonHandler());


$router = new router\Router();

$router->route('options', '/', function() {
	$method = new resource\method\Options('TEST');
	return $method->request();
}, 'OPTIONS');

$router->route('get', '/', function() {
	$method = new resource\method\Get('TEST');
	return $method->request();
}, 'GET');

$result = $router->match($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$handler = $handlers->getHandler($result);

if ($handler) {
    $handler->handle($result);
} else {
    $error = new handler\http\HttpStatus(404, ' ');
    $handler = $handlers->getHandler($error);
    $handler->handle($error);
}