<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;

class IntegrationHeadTest extends IntegrationTest {
	
	public function test200() {
		$resource = $this->createResource('test');
		
		$result = $this->route('/test' . $resource->id, \http\HttpMethod::METHOD_HEAD, HttpStatus::STATUS_200_OK, true);
		$this->assertNull($result);
	}
	
	public function test404NoSuchID() {
		$result = $this->route('/test/1', \http\HttpMethod::METHOD_HEAD, HttpStatus::STATUS_404_NOT_FOUND, true);
		$this->assertNull($result);
	}
	
	public function test404() {
		$result = $this->route('/test', \http\HttpMethod::METHOD_HEAD, HttpStatus::STATUS_404_NOT_FOUND, true);
		$this->assertNull($result);
	}
}
