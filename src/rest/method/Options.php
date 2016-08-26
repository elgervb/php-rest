<?php
namespace rest\method;

class Options extends AbstractRestMethod {
	
	/**
	 * Returns all resources
	 *
	 * @return HttpStatus 200
	 */
	public function request(array $params = null) {
		return new \handler\http\HttpStatus(200);
	}
}

