<?php

namespace rest\method;

abstract class AbstractRestMethod implements IRestMethod {
	
	private $attributes = [];
	private $resourceName;
	
	public function __construct($resourceName) {
		$this->resourceName = $resourceName;
	}

	public function attr($key, $value = null) {
		// getter
		if ($value === null) {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : '';
		}
	
		// setter
		$this->attributes[$key] = $value;
		
		return $this; // for chaining
	}
	
	/**
	 * Returns the name of the resource
	 * 
	 * @return string the name of the resource
	 */
	public function getResourceName() {
		return $this->resourceName;
	}
}