<?php
namespace rest\factory;

use rest\method\IRestMethod;
use rest\method\Delete;
use rest\method\Get;
use rest\method\Head;
use rest\method\Options;
use rest\method\Patch;
use rest\method\Post;
use rest\method\Put;
use rest\resource\RestException;

class RestMethodFactory {
	
	/**
	 * Creates a new HTTP method
	 * 
	 * @param string $methodName
	 * @param string $resourceName
	 * 
	 * @throws RestException when the method could not be mapped to a methodName
	 * 
	 * @return \rest\method\IRestMethod
	 */
	public static function create($methodName, $resourceName) {
		switch($methodName) {
			case IRestMethod::METHOD_DELETE :
				return new Delete($resourceName);
			case IRestMethod::METHOD_GET :
				return new Get($resourceName);
			case IRestMethod::METHOD_HEAD :
				return new Head($resourceName);
			case IRestMethod::METHOD_OPTIONS :
				return new Options($resourceName);
			case IRestMethod::METHOD_PATCH :
				return new Patch($resourceName);
			case IRestMethod::METHOD_POST : 
				return new Post($resourceName);
			case IRestMethod::METHOD_PUT :
				return new Put($resourceName);
			default :
				throw new RestException('Could not create method ' . $methodName );
		}
	}
}