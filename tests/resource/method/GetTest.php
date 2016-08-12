<?php
namespace resource\method;

use RedBeanPHP\R;

use resource\method;
use handler\http\HttpStatus;

class GetTest extends \PHPUnit_Framework_TestCase {
	
	public function setUp() {
		R::setup('sqlite:'.__DIR__.'/GetTest.sqlite');
		$labels = R::dispenseLabels('TEST', ['one', 'two', 'three']);
		R::storeAll($labels);
		
		$this->assertEquals(3, count(R::findAll('TEST')), 'There should be only 3 beans in the database');
	}
	
	public function tearDown() {
		R::nuke();
	}
	
	public function testRequestList() {
		$method = new Get('TEST');
		
		$result = $method->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus);
		$this->assertEquals(\handler\http\HttpStatus::STATUS_200_OK, $result->getHttpCode());
		
		/* @var $content \handler\json\Json */
		$content = $result->getContent();
		$this->assertTrue($content instanceof \handler\json\Json, 'Content is a ' . get_class($content));
	}
}
