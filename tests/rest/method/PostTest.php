<?php
namespace rest\method;

use rest\method;
use handler\http\HttpStatus;
use RedBeanPHP\R;

/**
 * @covers \rest\method\Post
 */
class PostTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/PostTest.sqlite');
	}
	
	public function setUp() {
		R::selectDatabase(__CLASS__);
		R::nuke();
	}
	
	/**
	 * @covers \rest\method\Post::__construct
	 * @covers \rest\method\Post::request
	 */
	public function testRequest() {
		$_POST['name'] = 'name1';
		
		$post = new Post('TEST');
		$result = $post->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_201_CREATED, $result->getHttpCode());
	}
	
	/**
	 * @covers \rest\method\Post::__construct
	 * @covers \rest\method\Post::request
	 */
	public function testRequestWithID() {
		$_POST['id'] = 1;
		$_POST['name'] = 'name1';
		
		$post = new Post('TEST');
		$result = $post->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_422_UNPROCESSABLE_ENTITY, $result->getHttpCode());
	}
	
	/**
	 * @covers \rest\method\Post::__construct
	 * @covers \rest\method\Post::request
	 */
	public function testRequestWithoutData() {
		$_POST = [];
		
		$post = new Post('TEST');
		$result = $post->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_204_NO_CONTENT, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
}
