<?php
namespace rest\resource;

use rest\factory\RestMethodFactory;
use rest\method\IRestMethod;

class RestResource implements IRestResource {
	
	private $resourceName;
	private $whitelist;
	private $options;
	
	public function __construct($resourceName, array $options = null) {
		$this->resourceName = $resourceName;
		$this->options = $options;
	}
	
	/**
	 * Checks the http method for whitelisting
	 * 
	 * @param string $httpMethod The http method to check (GET, POST, PUT)
	 * @throws RestException
	 * @return boolean true when whitelisted, false when not
	 */
	private function checkWhiteListed($httpMethod) {
		if (is_array($this->whitelist) && in_array($httpMethod, $this->whitelist)) {
			return true;
		} 
		
		throw new RestException($httpMethod . ' not whitelisted.');
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::delete()
	 */
	public function delete(array $params = null) {
		return $this->exec(IRestMethod::METHOD_DELETE);
	}
	
	/**
	 * Executes a restMethod after cheching it's whitelisting
	 * 
	 * @param string $methodName
	 * @param array $params
	 * 
	 * @return \handler\http\HttpStatus
	 * 
	 * @use RestMethodFactory::create
	 */
	private function exec($methodName, array $params = null) {
		$this->checkWhiteListed($methodName);
		
		$method = RestMethodFactory::create($methodName, $this->resourceName);
		return $method->request($params);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::get()
	 * 
	 * @use \rest\method\Get::request
	 */
	public function get(array $params = null) {
		$this->exec(IRestMethod::METHOD_GET);
	}
	
	/**
	 * Returns the resource name
	 * 
	 * @return string the resource name
	 */
	public function getResourceName() {
		return $this->resourceName;
	}
	
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::head()
	 */
	public function head(array $params = null) {
		return $this->exec(IRestMethod::METHOD_HEAD);
	}
	
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::options()
	 *
	 * @use \rest\method\Options::request
	 */
	public function options(array $params = null) {
		return $this->exec(IRestMethod::METHOD_OPTIONS);
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::patch()
	 */
	public function patch(array $params = null) {
		return $this->exec(IRestMethod::METHOD_PATCH);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::post()
	 * @use \rest\method\Post::request()
	 */
	public function post(array $params = null) {
		return $this->exec(IRestMethod::METHOD_POST);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::put()
	 * @use \rest\method\Put::request()
	 */
	public function put(array $params = null) {
		return $this->exec(IRestMethod::METHOD_PUT);
	}
	
	/**
	 * Add http methods to the whitelist
	 * 
	 * @param string ...$httpMethods
	 */
	public function whiteList(...$httpMethods) {
		if ($this->whitelist === null) {
			$this->whitelist = [];
		}
		
		foreach ($httpMethods as $httpMethod) {
			$this->whitelist[] = $httpMethod;
		}
	}
}