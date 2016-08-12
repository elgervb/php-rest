<?php
namespace rest\method;

use rest\method;
use handler\http\HttpStatus;

/**
 * @covers \rest\method\Options
 */
class OptionsTest extends \PHPUnit_Framework_TestCase {
	
	public function setUp() {
		
	}
	
	/**
	 * @covers \rest\method\Options::__construct
	 * @covers \rest\method\Options::request
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
