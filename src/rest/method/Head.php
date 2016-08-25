<?php
namespace rest\method;

use handler\http\HttpStatus;
use RedBeanPHP\R;

class Head extends AbstractRestMethod {
	
	private $beanName;
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
     * Head request
     *
     * @param $params the request parameters
     *        
     * @return HttpStatus 200 | 404 //
     *         200 when resource was found
     *         404 when the resource was not found.
     */
	public function request(array $params = null) {
		if (!is_array($params) || !array_key_exists('id', $params)) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		$resource = R::findOne($this->beanName, 'id = ?', [$params['id']]);
		if ($resource) {
			return new HttpStatus(HttpStatus::STATUS_200_OK);
		}
		
		return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND); 
	}
}

