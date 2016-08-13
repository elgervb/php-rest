<?php
namespace rest\method;

use RedBeanPHP\R;
use handler\http\HttpStatus;

/**
 * @covers \rest\method\Get
 */
class GetTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/GetTest.sqlite');
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
	 * Request multiple resources
	 * 
	 * @covers \rest\method\Get::__construct
	 * @covers \rest\method\Get::request
	 * @covers \rest\method\Get::findAll
	 */
	public function testRequestAll() {
		$method = new Get('TEST');
		
		$result = $method->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_200_OK, $result->getHttpCode());
		
		/* @var $content \handler\json\Json */
		$content = $result->getContent();
		$this->assertTrue($content instanceof \handler\json\Json, 'Content is a ' . get_class($content));
	
		$object = $content->getObject();
		$this->assertEquals(3, count($object));
		$this->assertEquals('one', $object[0]['name']);
		$this->assertEquals('two', $object[1]['name']);
		$this->assertEquals('three', $object[2]['name']);
	}
	
	/**
	 * Request a single resource
	 * 
	 * @covers \rest\method\Get::__construct
	 * @covers \rest\method\Get::request
	 * @covers \rest\method\Get::findOne
	 */
	public function testRequestOne() {
		$method = new Get('TEST');
		
		$result = $method->request(['id'=>1]);
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_200_OK, $result->getHttpCode());
		
		/* @var $content \handler\json\Json */
		$content = $result->getContent();
		$this->assertTrue($content instanceof \handler\json\Json, 'Content is a ' . get_class($content));

		$object = $content->getObject();
		$this->assertEquals('one', $object->name);
	}
	
	/**
	 * Request a single resource which does not exist
	 *
	 * @covers \rest\method\Get::__construct
	 * @covers \rest\method\Get::request
	 * @covers \rest\method\Get::findOne
	 */
	public function testRequestOneFail() {
		$method = new Get('TEST');
	
		$result = $method->request(['id'=>9]);
	
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
	
		/* @var $content \handler\json\Json */
		$content = $result->getContent();
		$this->assertTrue($content instanceof \handler\json\Json, 'Content is a ' . get_class($content));
		
		$object = $content->getObject();
		
		$this->assertEquals('No results found', $object['message']);
	}
}
