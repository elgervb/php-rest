<?php
namespace rest\method;

use rest\method\AbstractRestMethod;

class AbstractRestMethodtest extends \PHPUnit_Framework_TestCase {
	
	private $obj;
	
	public function setUp() {
		$this->obj = new MockRestMethod();
	}
	
	public function tearDown() {
		$this->obj = null;
	}
	
	public function testAttr() {
		$this->obj->attr('set', '123');
		$result = $this->obj->attr('set');
	
		$this->assertEquals('123', $result);
	}
	
	public function testAttrInitial() {
		$result = $this->obj->attr('get');
		
		$this->assertEquals('', $result);
	}
}

class MockRestMethod extends AbstractRestMethod {
	public function request(array $params = null) {
		
	}
}