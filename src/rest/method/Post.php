<?php
namespace rest\method;

use http\HttpContext;
use handler\http\HttpStatus;
use \RedBeanPHP\R;
use handler\json\Json;
use RedBeanPHP\RedException;

class Post extends AbstractRestMethod {
	
	private $beanName;
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
     * Create a new resource
     *
     * @param array $params
     *
     * @return HttpStatus 201 | 204 | 409 | 422 <br />
     *         <b>201</b> created, returning the new resource <br />
     *         <b>204</b> no content: when no post data available <br />
     *         <b>409</b> conflict on double entry <br />
     *         <b>422</b> Unprocessable Entity on validation errors <br />
     */
	public function request(array $params = null) {
		
		$request = HttpContext::get()->getRequest();
		if(!$request->hasPost()) {
			return new HttpStatus(HttpStatus::STATUS_204_NO_CONTENT);
		}
		
		// setting of ID is not allowed
		if (isset($_POST['id']) || isset($_POST['ID'])) {
			return new HttpStatus(HttpStatus::STATUS_422_UNPROCESSABLE_ENTITY);
		}
		
		$resource = R::dispense(strtolower($this->beanName));
		foreach ($_POST as $key => $value) {
			$resource->{$key} = $value;
		}
		
		try {
			$id = R::store($resource);
			$resource->id = $id;
			return new HttpStatus(HttpStatus::STATUS_201_CREATED, new Json($resource));
		} catch (RedException $ex) {
			return new HttpStatus(HttpStatus::STATUS_409_CONFLICT_ON_DOUBLE_ENTRY);
		}
		
		return new HttpStatus(HttpStatus::STATUS_409_CONFLICT_ON_DOUBLE_ENTRY);
	}
}
