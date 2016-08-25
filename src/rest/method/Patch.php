<?php
namespace rest\method;

use http\HttpContext;
use handler\http\HttpStatus;
use \RedBeanPHP\R;
use handler\json\Json;

class Patch extends AbstractRestMethod {
	
private $beanName;
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
     * Updates part of a resource
     *
     * @param $params the request parameters
     *        
     * @return HttpStatus 200 | 204 | 404 //
     *         200 when update was successfull
     *         204 no content when no post data available
     *         404 when $aId was not found.
     */
	public function request(array $params = null) {
			
		$request = HttpContext::get()->getRequest();
		
		if(!$request->hasPost()) {
			return new HttpStatus(HttpStatus::STATUS_204_NO_CONTENT);
		}
		
		if (!isset($params['id'])) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		$resource = R::findOne($this->beanName, 'id = ?', [$params['id']]);
		if (!$resource) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		foreach ($_POST as $key => $value) {
			if (strtolower($key) !== 'id') {
				$resource->{$key} = $value;
			}
		}
		
		try {
			$id = R::store($resource);
			return new HttpStatus(HttpStatus::STATUS_200_OK, new Json($resource));
		} catch (RedException $ex) {
			return new HttpStatus(HttpStatus::STATUS_500_INTERNAL_SERVER_ERROR);
		}
		
	}
}