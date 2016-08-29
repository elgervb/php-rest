<?php
namespace rest\route;

use \rest\resource\RestResource;
use router\Router;
use http\HttpRequest;

class ResourceRoute {
	
	/**
	 * @var \rest\resource\RestResource
	 */
	private $resource;
	
	public function __construct(RestResource $resource, Router $router) {
		$this->resource = $resource;
		$this->routeGet($router);
	}
	
	private function getResourceSlug() {
		return strtolower($this->resource->getResourceName());
	}
	
	private function routeDelete(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('put', '/' . $slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->post();
		}, HttpRequest::METHOD_DELETE); 
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
		}, HttpRequest::METHOD_GET);
	
		$router->route('get-by-id', "^/$slug/([0-9]+)$", function($id) use ($resource) {
			return $resource->get(['id'=>$id]);
		}, HttpRequest::METHOD_GET);
	}
	
	private function routeHead(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('get-by-id', '/'.$slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->head(['id'=>$id]);
		}, HttpRequest::METHOD_HEAD);
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
		}, 'OPTIONS'); // TODO use HttpRequest constant
	}
	
	private function routePatch(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('put', '/' . $slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->patch();
		}, HttpRequest::METHOD_PATCG);
	}
	
	private function routePost(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
		
		$router->route('post', '/' . $slug, function() use ($resource) {
			return $resource->post();
		}, HttpRequest::METHOD_POST);
	}
	
	private function routePut(Router $router) {
		$slug = $this->getResourceSlug();
		$resource = $this->resource;
	
		$router->route('put', '/' . $slug.'/([0-9]+)', function($id) use ($resource) {
			return $resource->post();
		}, HttpRequest::METHOD_PUT);
	}
}