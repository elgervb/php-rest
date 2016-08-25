<?php
namespace rest\method;

use rest\method;
use handler\http\HttpStatus;
use test\RestMethodTest;
use RedBeanPHP\R;

/**
 * @covers \rest\method\Head
 */
class HeadTest extends RestMethodTest {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/HeadTest.sqlite');
	}
	
	public function setUp() {
		R::selectDatabase(__CLASS__);
		R::nuke();
	}
	
	public function tearDown() {
		R::nuke();
	}
	
	/**
	 * @covers \rest\method\Head::__construct
	 * @covers \rest\method\Head::request
	 */
	public function test404NoId() {
		$head = new Head('test404NoId');
		$result = $head->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
	
	/**
	 * @covers \rest\method\Head::__construct
	 * @covers \rest\method\Head::request
	 */
	public function test404() {
		$resourceName = 'test404';
		$id = $this->createResource($resourceName)->id;
		$head = new Head($resourceName);
		$result = $head->request(['id'=>$id + 1]);
	
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
	
	/**
	 * @covers \rest\method\Head::__construct
	 * @covers \rest\method\Head::request
	 */
	public function test200() {
		$resourceName = 'test200';
		$id = $this->createResource($resourceName)->id;
		
		$head = new Head($resourceName);
		$result = $head->request(['id'=> $id]);
	
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_200_OK, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
}
