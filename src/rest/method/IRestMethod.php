<?php
namespace rest\method;

/**
 * Interface for REST method
 *  
 * @author elgervb
 */
interface IRestMethod {
	
	const METHOD_DELETE = 'DELETE';
	const METHOD_GET = 'GET';
	const METHOD_HEAD = 'HEAD';
	const METHOD_OPTIONS = 'OPTIONS';
	const METHOD_PATCH = 'PATCH';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	
	/**
	 * Add an attribute to the rest method
	 * @param mixed $key
	 * @param mixed $value optional, omit for getter function
	 */
	public function attr($key, $value);
	
	/**
	 * Makes the request
	 * 
	 * @param array $params optional parameters
	 * 
	 * @return handler/http/HttpStatus
	 */
	public function request(array $params = null);
}
