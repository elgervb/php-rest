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
	public function request() {
		return new \handler\http\HttpStatus(200);
	}
}

