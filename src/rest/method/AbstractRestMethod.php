<?php

namespace rest\method;

abstract class AbstractRestMethod implements IRestMethod {
	
	private $attributes = [];

	public function attr($key, $value = null) {
		// getter
		if ($value === null) {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : '';
		}
	
		// setter
		$this->attributes[$key] = $value;
		
		return $this; // for chaining
	}
}