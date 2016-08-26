<?php
namespace rest\method;

use http\HttpContext;
use handler\http\HttpStatus;
use \RedBeanPHP\R;
use handler\json\Json;
use RedBeanPHP\RedException;

class Put extends AbstractRestMethod {
	
	/**
     * Updates a single model
     *
     * @param array $params
     *             
     * @return HttpStatus 200 | 204 | 404 <br />
     *         <b>200</b> when update was successfull with in the body the saved model <br />
     *         <b>204</b> no content when no post data available <br />
     *         <b>404</b> when ID was not found. <br />
     *         <b>422</b> Unprocessable Entity on validation errors <br />
     */
	public function request(array $params = null) {
		
		$request = HttpContext::get()->getRequest();
		
		if(!$request->hasPost()) {
			return new HttpStatus(HttpStatus::STATUS_204_NO_CONTENT);
		}
		
		if (!is_array($params) || !array_key_exists('id', $params)) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		// check if resource with ID is available
		if (!R::findOne($this->getResourceName(), 'id = ?', [$params['id']])) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		// Create a new resource
		$resource = R::dispense($this->getResourceName());
		
		foreach ($_POST as $key => $value) {
			if (strtolower($key) !== 'id') {
				$resource->{$key} = $value;
			}
		}
		
		$resource->{'id'} = $params['id'];
		
		try {
			$id = R::store($resource);
			return new HttpStatus(HttpStatus::STATUS_200_OK, new Json($resource));
		} catch (RedException $ex) {
			return new HttpStatus(HttpStatus::STATUS_500_INTERNAL_SERVER_ERROR);
		}
		
	}
}
