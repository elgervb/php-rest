<?php
namespace resource\method;

class Get extends AbstractRestMethod {
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
	 * Returns all resources or a single one when the $params contains an ID
	 * 
	 * @param array $params 
	 *
	 * @return HttpStatus 200 | 204
	 *         200 with JSON of the models found
	 *         204 no content when there are no models in the database
	 */
	public function request(array $params = null) {
		
		if (isset($params) && is_array($params) && array_key_exists('id', $params)) {
			return $this->findOne($params);
		}
		return $this->findAll();
	}
	
	/**
	 * Find exactly one resource
	 * 
	 * @param array $params
	 * 
	 * @return \handler\http\HttpStatus
	 */
	private function findOne(array $params) {
		$resource = \RedBeanPHP\R::findOne($this->beanName, 'id = ?', [$params['id']]);
		if ($resource) {
			$json = new \handler\json\Json($resource);
			return new \handler\http\HttpStatus(200, $json);
		}
		
		$json = new \handler\json\Json(['message' => 'No results found']);
		return new \handler\http\HttpStatus(404, $json);
	}
		
	
	/**
	 * Finds all resources of this type
	 */
	 private function findAll() {
		$resources = \RedBeanPHP\R::findAll($this->beanName);
		
		$result = [];
		
		if ($resources) {
			/* @var $resource RedBeanPHP\OODBBean */
			foreach ($resources as $resource) {
				$result[] = $resource->export();
			}
		} else {
			$json = new \handler\json\Json(['message' => 'No results found']);
			return new \handler\http\HttpStatus(404, $json);
		}
		
		$json = new \handler\json\Json($result);
		
		return new \handler\http\HttpStatus(200, $json);
	}

}
