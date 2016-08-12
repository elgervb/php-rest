<?php
namespace resource\method;

class Options extends AbstractRestMethod {
	
	public function __construct() {
		
	}
	
	/**
	 * Returns all resources
	 *
	 * @return HttpStatus 200
	 */
	public function request(array $params = null) {
		return new \handler\http\HttpStatus(200);
	}
}

