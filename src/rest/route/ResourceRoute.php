<?php
namespace rest\route;

use \rest\resource\RestResource;
use router\Router;
use http\HttpRequest;
use http\HttpMethod;

class ResourceRoute {
	
	/**
	 * @var \rest\resource\RestResource
	 */
	private $resource;
	
	public function __construct(RestResource $resource, Router $router) {
		$this->resource = $resource;
		$this->routeDelete($router);
		$this->routeGet($router);
		$this->routeHead($router);
		$this->routeOptions($router);
		$this->routePatch($router);
		$this->routePost($router);
		$this->routePut($router);
	}
	
	private function getResourceSlug() {
		return strtolower($this->resource->getResourceName());
	}
	
	private function routeDelete(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('delete', '/' . $slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->post();
		}, HttpMethod::METHOD_DELETE); 
	}
	
	/**
	 * Register all routes for GET http method
	 * @param Router $router
	 */
	private function routeGet(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
		
		$router->route('get', "^/$slug$", function() use ($resource) {
			return $resource->get();
		}, HttpMethod::METHOD_GET);
	
		$router->route('get-by-id', "^/$slug/([0-9]+)$", function($id) use ($resource) {
			return $resource->get(['id'=>$id]);
		}, HttpMethod::METHOD_GET);
	}
	
	private function routeHead(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('head', "/$slug/([0-9]+)", function($id) use ($resource) {
			return $resource->head(['id'=>$id]);
		}, HttpMethod::METHOD_HEAD);
	}
	
	/**
	 * Register all routes for OPTIONS http method
	 * @param Router $router
	 */
	private function routeOptions(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
		
		$router->route('options', '/' . $slug, function() use ($resource) {
			return $resource->options();
		}, HttpMethod::METHOD_OPTIONS);
	}
	
	private function routePatch(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('patch', '/' . $slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->patch();
		}, HttpMethod::METHOD_PATCH);
	}
	
	private function routePost(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
		
		$router->route('post', '/' . $slug, function() use ($resource) {
			return $resource->post();
		}, HttpMethod::METHOD_POST);
	}
	
	private function routePut(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('put', '/' . $slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->put(['id'=>$id]);
		}, HttpMethod::METHOD_PUT);
	}
}