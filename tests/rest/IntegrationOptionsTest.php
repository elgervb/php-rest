<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;

class IntegrationOptionsTest extends IntegrationTest {
	
	public function test200() {
		$resource = $this->createResource('test');
		
		$result = $this->route('/test/' . $resource->id, \http\HttpMethod::METHOD_OPTIONS, HttpStatus::STATUS_200_OK, true);
		$this->assertNull($result);
	}
	
	public function test200Id() {
		$resource = $this->createResource('test');
	
		$result = $this->route('/test/' . $resource->id, \http\HttpMethod::METHOD_OPTIONS, HttpStatus::STATUS_200_OK, true);
		$this->assertNull($result);
	}
}
