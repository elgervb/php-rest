<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;

class IntegrationPostTest extends IntegrationTest {
	
	public function test201() {
		$this->mockPost('one', 1);
		$this->mockPost('two', 2);
	
		$result = $this->route('/test', \http\HttpMethod::METHOD_POST, HttpStatus::STATUS_201_CREATED, true);
		$this->assertEquals($result->one, 1);
		$this->assertEquals($result->two, 2);
	}
	
	public function test204() {
		$result = $this->route('/test', \http\HttpMethod::METHOD_POST, HttpStatus::STATUS_204_NO_CONTENT, true);
		$this->assertNull($result);
	}
	
	public function test422() {
		$this->mockPost('id', 1);
	
		$result = $this->route('/test', \http\HttpMethod::METHOD_POST, HttpStatus::STATUS_422_UNPROCESSABLE_ENTITY, true);
		$this->assertNull($result);
	}
}
