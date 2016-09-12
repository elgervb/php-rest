<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;
	
class IntegrationPatchTest extends IntegrationTest {
	
	public function test200() {
		$resource = $this->createResource('test');
		
		$expected = 'test200';
		$this->mockPost('name', $expected);
		
		$result = $this->route('/test/' . $resource->id, \http\HttpMethod::METHOD_PATCH, HttpStatus::STATUS_200_OK, true);
		$this->assertEquals($result->name, $expected);
	}
	
	public function test204() {
		$result = $this->route('/test/12', \http\HttpMethod::METHOD_PATCH, HttpStatus::STATUS_204_NO_CONTENT, true);
		$this->assertNull($result);
	}
	
	public function test404() {
		$this->mockPost('one', 1);
		$this->mockPost('two', 2);
	
		$result = $this->route('/test/12', \http\HttpMethod::METHOD_PATCH, HttpStatus::STATUS_404_NOT_FOUND, false);
		$this->assertNull($result);
	}
}
