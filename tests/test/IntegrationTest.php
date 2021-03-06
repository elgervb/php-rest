<?php
namespace test;

use \RedBeanPHP\R;

abstract class IntegrationTest extends RestMethodTest {
	
	private $router;
	
	public static function setUpBeforeClass() {
		$dbFile = __DIR__ . '/IntegrationTest.sqlite';
		if (is_file($dbFile)) {
			unlink($dbFile);
		}
		
		$random = rand(1000, PHP_INT_MAX);
		
		R::addDatabase('integration'.$random, "sqlite:$dbFile");
		R::selectDatabase('integration'.$random);
		
		$handlers = \handler\Handlers::get();
		$handlers->add(new \handler\http\HttpStatusHandler());
		$handlers->add(new \handler\json\JsonHandler());
	}
	
	public function setUp () {
		$this->router = new \router\Router();
		$resource = new \rest\resource\RestResource('test');
		$resource->whiteList('DELETE', 'GET', 'HEAD', 'OPTIONS', 'PATCH', 'POST', 'PUT');
		new \rest\route\ResourceRoute($resource, $this->router);
	}
	
	protected function tearDown() {
		$this->clearPost();
		R::nuke();
	}
	
	/**
	 * Execute a route with a given HttpMethod and returns the result
	 * @param string $route The REQUEST_URI
	 * @param HttpMethod $requestMethod
	 * @param boolean $assertNotNull add assert whether the result is not null
	 * @return mixed|null
	 */
	protected function execRoute($route, $requestMethod, $assertStatusCode, $assertNotNull = false) {
		/* @var $result \handler\http\HttpStatus */
		$result = $this->router->match($route, $requestMethod);
		
		if ($result === false) {
			$this->fail('No route found for ' . $route);
		}
		
		if ($assertNotNull) {
			$this->assertNotNull($result, "No result from route $route $requestMethod");
			$this->assertTrue($result instanceof \handler\http\HttpStatus);
		}

		$this->assertEquals($assertStatusCode, $result->getHttpCode(), 'Http status code not correct');
		
		return $result;
	}
	
	protected function route($route, $requestMethod, $assertStatusCode, $assertNotNull = false) {
		$result = $this->execRoute($route, $requestMethod, $assertStatusCode, $assertNotNull);
		return $this->execHandler($result, $assertNotNull);
	}
	
	protected function execHandler($result, $assertStatucCode = 'unknown', $assertNotNull = false) {
		$handler = \handler\Handlers::get()->getHandler($result);
		if ($assertNotNull) {
			$this->assertNotNull($handler, "No handler found");
			$this->assertTrue($handler instanceof \handler\http\HttpStatusHandler, "Handler found was of type " . get_class($handler));
		}
	    $handler->handle($result);
	    
	    $content = $result->getContent();
	    return $content ? $content->getObject() : $content;
	}
	
	protected function mockPost($key, $value) {
		$_POST[$key] = $value;
	}
	
	protected function assertIsArray($actual, $withCount = false) {
		$this->assertTrue(is_array($actual), 'Actual is not an array');
		if (is_numeric($withCount)) {
			$this->assertEquals($withCount, count($actual));
		}
	}
	
	protected function clearPost() {
		$_POST = [];
	}
}