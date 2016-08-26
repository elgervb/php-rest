<?php
namespace rest\route;

use \rest\resource\RestResource;
use router\Router;

class ResourceRoute {
	
	/**
	 * @var \rest\resource\RestResource
	 */
	private $resource;
	
	public function __construct(RestResource $resource, Router $router) {
		$this->resource = $resource;
		$this->routeGet($router);
	}
	
	/**
	 * Register all routes for GET http method
	 * @param Router $router
	 */
	private function routeGet(Router $router) {
		$slug = strtolower($this->resource->getResourceName());
		$resource = $this->resource;
		
		$router->route('get', '/' . $slug, function() use ($resource) {
			return $resource->get();
		}, 'GET');
	
		$router->route('get-by-id', '/'.$slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->get(['id'=>$id]);
		}, 'GET');
	}
	
	/**
	 * Register all routes for OPTIONS http method
	 * @param Router $router
	 */
	private function routeOptions(Router $router) {
		$resource = $this->resource;
		$router->route('options', '/' . $slug, function() use ($resource) {
			return $resource->options();
		}, 'OPTIONS');
	}
}