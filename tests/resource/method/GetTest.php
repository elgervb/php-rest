<?php
namespace resource\method;

use RedBeanPHP\R;

use resource\method;
use handler\http\HttpStatus;

/**
 * @covers resource\method\Get
 */
class GetTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::setup('sqlite:'.__DIR__.'/GetTest.sqlite');
	}
	
	public function setUp() {
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
	 * Request multiple resources
	 * 
	 * @covers resource\method\Get::__construct
	 * @covers resource\method\Get::request
	 * @covers resource\method\Get::findAll
	 */
	public function testRequestAll() {
		$method = new Get('TEST');
		
		$result = $method->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_200_OK, $result->getHttpCode());
		
		/* @var $content \handler\json\Json */
		$content = $result->getContent();
		$this->assertTrue($content instanceof \handler\json\Json, 'Content is a ' . get_class($content));
	}
	
	/**
	 * Request a single resource
	 * 
	 * @covers resource\method\Get::__construct
	 * @covers resource\method\Get::request
	 * @covers resource\method\Get::findOne
	 */
	public function testRequestOne() {
		$method = new Get('TEST');
		
		$result = $method->request(['id'=>1]);
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_200_OK, $result->getHttpCode());
		
		/* @var $content \handler\json\Json */
		$content = $result->getContent();
		$this->assertTrue($content instanceof \handler\json\Json, 'Content is a ' . get_class($content));
	}
}
