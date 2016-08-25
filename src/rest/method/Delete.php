<?php
namespace rest\method;

use handler\http\HttpStatus;

class Delete extends AbstractRestMethod {
	
	private $beanName;
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
     * Delete a single resource
     *
     * @param $params the request parameters
     *
     * @return HttpStatus 200 | 404 //
     *         200 when the resource has been deleted
     *         404 when the resource could not be found,
     */
	public function request(array $params = null) {
		
		if (!is_array($params) || !array_key_exists('id', $params)) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		$resource = \RedBeanPHP\R::findOne($this->beanName, 'id = ?', [$params['id']]);
		if ($resource) {
			\RedBeanPHP\R::trash($resource);
			
			return new HttpStatus(HttpStatus::STATUS_200_OK);
		}
		
		return New HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
	}
}

