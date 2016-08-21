<?php
namespace rest\resource;

class RestResource implements IRestResource {
	
	private $beanName;
	private $whitelist;
	private $options;
	
	public function __construct($beanName, array $options = null) {
		$this->beanName = $beanName;
		// TODO
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::get()
	 * 
	 * @use \rest\method\Get::request
	 */
	public function get(array $params = null) {
		$this->checkWhiteListed('GET');
		
		$get = new \rest\method\Get($this->beanName);
		return $get->request($params);
	}
	
	public function getBeanName() {
		return $this->beanName;
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
	 * @see \rest\resource\IRestResource::options()
	 *
	 * @use \rest\method\Options::request
	 */
	public function options(array $params = null) {
		$this->checkWhiteListed('OPTIONS');
		
		$options = new \rest\method\Options();
		return $options->request($params);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::post()
	 * @use \rest\method\Post::request()
	 */
	public function post(array $params = null) {
		$this->checkWhiteListed('POST');
		
		$post = new \rest\method\Post($this->beanName);
		return $post->request($params);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rest\resource\IRestResource::put()
	 * @use \rest\method\Put::request()
	 */
	public function put(array $params = null) {
		$this->checkWhiteListed('POST');
	
		$put = new \rest\method\Put($this->beanName);
		return $put->request($params);
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