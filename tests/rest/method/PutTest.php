<?php
namespace rest\method;

use rest\method;
use handler\http\HttpStatus;
use RedBeanPHP\R;

/**
 * @covers \rest\method\Put
 */
class PutTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/PutTest.sqlite');
	}
	
	public function setUp() {
		R::selectDatabase(__CLASS__);
		R::nuke();
	}
	
	private function createEntry() {
		$_POST['name'] = 'name'.rand(1, 1024);
		
		$post = new Post('test');
		$result = $post->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_201_CREATED, $result->getHttpCode());
		
		$_POST = [];
		
		return $result->getContent()->getObject()->id;
	}
	
	/**
	 * @covers \rest\method\Put::__construct
	 * @covers \rest\method\Put::request
	 */
	public function testRequest() {
		$_POST['name'] = 'name1';
		
		$put = new Put('test');
		$result = $put->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
	}
	
	/**
	 * @covers \rest\method\Put::__construct
	 * @covers \rest\method\Put::request
	 */
	public function testRequestWithID() {
		$id = $this->createEntry(1);
		
		$_POST['id'] = $id;
		$_POST['name'] = 'name2';
		
		$put = new Put('test');
		$result = $put->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_200_OK, $result->getHttpCode());
	}
	
	/**
	 * @covers \rest\method\Put::__construct
	 * @covers \rest\method\Put::request
	 */
	public function testRequestWithoutData() {
		$_POST = [];
		
		$put = new Put('test');
		$result = $put->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_204_NO_CONTENT, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
}
