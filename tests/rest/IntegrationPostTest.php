<?php
namespace rest;

use test\IntegrationTest;
use handler\http\HttpStatus;

class IntegrationPostTest extends IntegrationTest {
	
	public function testPost() {
		$this->mockPost('one', 1);
		$this->mockPost('two', 2);
	
		$result = $this->route('/test', \http\HttpMethod::METHOD_POST, HttpStatus::STATUS_201_CREATED, true);
		$this->assertEquals($result->one, 1);
		$this->assertEquals($result->two, 2);
	}
}