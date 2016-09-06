<?php
namespace rest\method;

class Get extends AbstractRestMethod {
	
	/**
	 * Returns all resources or a single one when the $params contains an ID
	 * 
	 * @param array $params 
	 *
	 * @return HttpStatus 200 | 204
	 *         200 with JSON of the models found
	 *         404 no content when there are no models in the database
	 */
	public function request(array $params = null) {
		
		if (is_array($params) && array_key_exists('id', $params)) {
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
		$resource = \RedBeanPHP\R::findOne($this->getResourceName(), 'id = ?', [$params['id']]);
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
		$resources = \RedBeanPHP\R::findAll($this->getResourceName());
		
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
