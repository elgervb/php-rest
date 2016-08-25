<?php
namespace rest\method;

use RedBeanPHP\R;
use handler\http\HttpStatus;

/**
 * @covers \rest\method\Get
 */
class DeleteTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/DeleteTest.sqlite');
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
	 * Request deletion without an id
	 * 
	 * @covers \rest\method\Delete::__construct
	 * @covers \rest\method\Delete::request
	 */
	public function test404NoID() {
		$method = new Delete('TEST');
		
		$result = $method->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());

		$this->assertEquals(3, count(R::findAll('TEST')), 'There should be 3 beans in the database');
	}
	
	/**
	 * Request deletion of an non-existing ID
	 *
	 * @covers \rest\method\Delete::__construct
	 * @covers \rest\method\Delete::request
	 */
	public function test404() {
		$method = new Delete('TEST');
	
		$result = $method->request(['id'=>4]);
	
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
	
		$this->assertEquals(3, count(R::findAll('TEST')), 'There should be 3 beans in the database');
	}
	
	/**
	 * Request deletion of an existing ID
	 *
	 * @covers \rest\method\Delete::__construct
	 * @covers \rest\method\Delete::request
	 */
	public function test200() {
		$method = new Delete('TEST');
	
		$result = $method->request(['id'=>1]);
	
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_200_OK, $result->getHttpCode());
	
		$this->assertEquals(2, count(R::findAll('TEST')), 'There should be 2 beans in the database');
	}
}
