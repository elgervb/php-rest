<?php
namespace rest\factory;

use rest\method\IRestMethod;

class RestMethodFactoryTest extends \PHPUnit_Framework_TestCase {
	
	const RESOURCE_NAME = 'test';
	
	public function testCreate() {
		$this->assertRestMethod(IRestMethod::METHOD_DELETE);
		$this->assertRestMethod(IRestMethod::METHOD_GET);
		$this->assertRestMethod(IRestMethod::METHOD_HEAD);
		$this->assertRestMethod(IRestMethod::METHOD_OPTIONS);
		$this->assertRestMethod(IRestMethod::METHOD_PATCH);
		$this->assertRestMethod(IRestMethod::METHOD_POST);
		$this->assertRestMethod(IRestMethod::METHOD_PUT);
	}
	
	public function testCreateFail() {
		$hasException = false;
		try {
			RestMethodFactory::create('NON_EXISTING_METHOD', self::RESOURCE_NAME);
		} catch (\rest\resource\RestException $ex) {
			$hasException = true;
		}
		
		$this->assertTrue($hasException);
	}
	
	/**
	 * Check the validity of the rest method provided
	 * 
	 * @param string $methodName
	 */
	private function assertRestMethod($methodName) {
		$method = RestMethodFactory::create($methodName, self::RESOURCE_NAME);
		
		$this->assertTrue($method instanceof \rest\method\IRestMethod);
	}
}