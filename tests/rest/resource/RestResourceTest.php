<?php
namespace rest\resource;

use RedBeanPHP\R;

/**
 * @covers \rest\resource\RestResource
 */
class RestResourceTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/RestResourceTest.sqlite');
	}	
	
	public function setUp() {
		R::selectDatabase(__CLASS__);
		R::nuke();
		$labels = R::dispenseLabels('TEST', ['one', 'two', 'three']);
		R::storeAll($labels);
	}
	
	protected function assertPreConditions() {
		$this->assertEquals(3, count(R::findAll('TEST')), 'There should be only 3 beans in the database');
	}
	
	public function tearDown() {
		R::nuke();
	}
	
	/**
	 * @covers \rest\resource\RestResource::getResourceName
	 */
	public function testGetResourceName() {
		$name = 'TEST';
		$resource = new RestResource($name);
		
		$this->assertEquals($name, $resource->getResourceName());
	}
	
	/**
	 * @covers \rest\resource\RestResource::__construct
	 * @covers \rest\resource\RestResource::whiteList
	 * @covers \rest\resource\RestResource::get
	 */
	public function testWhitelist() {
		$resource = new RestResource('TEST');
		$resource->whiteList('GET');
		$resource->get(); // should succeed
	}
	
	/**
	 * @covers \rest\resource\RestResource::__construct
	 * @covers \rest\resource\RestResource::options
	 */
	public function testWhitelistFail() {
		$resource = new RestResource('TEST');
		$resource->whiteList('GET');
		try {
			$resource->options();
			$this->fail();
		} catch (\rest\resource\RestException $ex) {
			// succeed
		}
	}
}
