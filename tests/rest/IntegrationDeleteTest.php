<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;

class IntegrationDeleteTest extends IntegrationTest {

	const RESOURCE_TYPE = "test";
	
	public function test200() {
		$resource = $this->createResource(self::RESOURCE_TYPE);
		
		$this->assertFindByID(self::RESOURCE_TYPE, $resource->id);
		
		$result = $this->route('/test/' . $resource->id, \http\HttpMethod::METHOD_DELETE, HttpStatus::STATUS_200_OK, true);
		$this->assertNull($result);
		$this->assertNull($this->findByID(self::RESOURCE_TYPE, $resource->id));
	}
	
	public function test404() {
		$resource = $this->createResource(self::RESOURCE_TYPE);
		
		$result = $this->route('/test/'.($resource->id + 1), \http\HttpMethod::METHOD_DELETE, HttpStatus::STATUS_404_NOT_FOUND, false);
		$this->assertNull($result);
	}
}
