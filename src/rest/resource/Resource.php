<?php
namespace rest\resource;

class Resource implements IRestResource {
	
	private $whitelist;
	private $options;
	
	public function __construct(array $options = null) {
		// TODO
	}
	
	public function get() {
		$this->checkWhiteListed('GET');
		
		// TODO
	}
	
	/**
	 * Checks the http method for whitelisting
	 * 
	 * @param string $httpMethod The http method to check (GET, POST, PUT)
	 * @throws RestException
	 * @return boolean true when whitelisted, false when not
	 */
	private function checkWhiteListed($httpMethod) {
		if ($this->whiteList === null || is_array($this->whitelist) && in_array($httpMethod, $this->whitelist)) {
			return true;
		} 
		
		throw new RestException($httpMethod . ' not whitelisted.');
	}
	
	public function options() {
		$this->checkWhiteListed('OPTIONS');
		
		// TODO
	}
	
	public function whiteList(...$httpMethods) {
		if ($this->whitelist === null) {
			$this->whitelist = [];
		}
		
		foreach ($httpMethods as $httpMethod) {
			$this->whitelist[$httpMethod];
		}
	}
}