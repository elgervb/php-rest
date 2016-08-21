<?php
namespace rest\method;

use http\HttpContext;
use handler\http\HttpStatus;
use \RedBeanPHP\R;
use handler\json\Json;
use RedBeanPHP\RedException;

class Put extends AbstractRestMethod {
	
	private $beanName;
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
     * Updates a single model
     *
     * @param $aId mixed            
     * @return HttpStatus 200 | 204 | 404 <br />
     *         <b>200</b> when update was successfull with in the body the saved model <br />
     *         <b>204</b> no content when no post data available <br />
     *         <b>404</b> when ID was not found. <br />
     *         <b>409</b> conflict on double entry <br />
     *         <b>422</b> Unprocessable Entity on validation errors <br />
     */
	public function request(array $params = null) {
		
		$request = HttpContext::get()->getRequest();
		
		if(!$request->hasPost()) {
			return new HttpStatus(HttpStatus::STATUS_204_NO_CONTENT);
		}
		
		if (!isset($_POST['id'])) {
			return new HttpStatus(HttpStatus::STATUS_404_NOT_FOUND);
		}
		
		$resource = R::findOne($this->beanName, 'id = ?', [$_POST['id']]);
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
			return new HttpStatus(HttpStatus::STATUS_409_CONFLICT_ON_DOUBLE_ENTRY);
		}
		
		return new HttpStatus(HttpStatus::STATUS_409_CONFLICT_ON_DOUBLE_ENTRY);
	}
}
