<?php
namespace resource\method;

class Get extends AbstractRestMethod {
	
	public function __construct($beanName) {
		$this->beanName = $beanName;
	}
	
	/**
	 * Returns all resources
	 *
	 * @return HttpStatus 200 | 204
	 *         200 with JSON of the models found
	 *         204 no content when there are no models in the database
	 */
	public function request() {
		
		$resources = \RedBeanPHP\R::find($this->beanName);
		
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

