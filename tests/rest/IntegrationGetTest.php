<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;
use RedBeanPHP\OODBBean;

class IntegrationGetTest extends IntegrationTest {
	
	public function test200() {
		$resource = $this->createResource('test');
		
		$result = $this->route('/test/' . $resource->id, \http\HttpMethod::METHOD_GET, HttpStatus::STATUS_200_OK, true);
		$this->assertTrue($result instanceof OODBBean);
		$this->assertEquals($resource->id, $result->id);
		$this->assertEquals($resource->name, $result->name);
	}
	
	public function test200Multiple() {
		$resource1 = $this->createResource('test');
		$resource2 = $this->createResource('test');
	
		$result = $this->route('/test', \http\HttpMethod::METHOD_GET, HttpStatus::STATUS_200_OK, true);
		$this->assertIsArray($result);
		
		$this->assertEquals($resource1->id, $result[0]['id']);
		$this->assertEquals($resource1->name, $result[0]['name']);
		
		$this->assertEquals($resource2->id, $result[1]['id']);
		$this->assertEquals($resource2->name, $result[1]['name']);
	}
	
	public function test404NoSuchID() {
		$result = $this->route('/test/1', \http\HttpMethod::METHOD_GET, HttpStatus::STATUS_404_NOT_FOUND, true);
		$this->assertIsArray($result);
		$this->assertEquals('No results found', $result['message']);
	}
	public function test404NoResources() {
		$result = $this->route('/test', \http\HttpMethod::METHOD_GET, HttpStatus::STATUS_404_NOT_FOUND, true);
		$this->assertIsArray($result);
		$this->assertEquals('No results found', $result['message']);
	}
}
