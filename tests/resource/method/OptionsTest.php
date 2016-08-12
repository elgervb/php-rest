<?php
namespace resource\method;

use resource\method;
use handler\http\HttpStatus;

/**
 * @covers resource\method\Options
 */
class OptionsTest extends \PHPUnit_Framework_TestCase {
	
	public function setUp() {
		
	}
	
	/**
	 * @covers resource\method\Options::__construct
	 * @covers resource\method\Options::request
	 */
	public function testRequest() {
		$options = new Options();
		$result = $options->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_200_OK, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
}
