<?php
namespace rest\route;

use rest\resource\IRestResource;
			
 class ResourceRouteTest extends \PHPUnit_Framework_TestCase {

 	const PREFIX = 'username';
 	const RESOURCE_NAME = 'test';
 	
 	private $router;
 	private $resource;
 	
 	public function setUp() {
 		$this->router = new \router\Router();
 		
 		$this->resource = new MockResource(self::RESOURCE_NAME);
 	}
 	
 	public function testGet() {
 		new ResourceRoute($this->resource, $this->router);
 		
 		$route = '/test';
 		
 		$result = $this->router->match($route, 'GET');
 		$this->assertTrue($result);
 	}
 	
 	public function testGetWithPrefix() {
 		new ResourceRoute($this->resource, $this->router, 'elgervb');
 		
 		$route = '/elgervb/test';
 			
 		$result = $this->router->match($route, 'GET');
 		$this->assertTrue($result);
 	}
 	
 	public function testGetWithPrefixWithSlash() {
 		new ResourceRoute($this->resource, $this->router, '/elgervb');
 			
 		$route = '/elgervb/test';
 	
 		$result = $this->router->match($route, 'GET');
 		$this->assertTrue($result);
 	}
 	
 	public function testGetWithPrefixLongPath() {
 		new ResourceRoute($this->resource, $this->router, '/elgervb/vb/qwerty');
 			
 		$route = '/elgervb/vb/qwerty/test';
 	
 		$result = $this->router->match($route, 'GET');
 		$this->assertTrue($result);
 	}
 }
 
 
 class MockResource implements IRestResource {
 	private $name;
 	
 	public function __construct($name) {
 		$this->name = $name;
 	}
 	public function getResourceName() {
 		return $this->name;
 	}
 	public function delete(array $params = null){
 		return true;
 	}
 	public function get(array $params = null){
 		return true;
 	}
 	public function head(array $params = null){
 		return true;
 	}
 	public function options(array $params = null){
 		return true;
 	}
 	public function patch(array $params = null){
 		return true;
 	}
 	public function post(array $params = null){
 		return true;
 	}
 	public function put(array $params = null){
 		return true;
 	}
 }