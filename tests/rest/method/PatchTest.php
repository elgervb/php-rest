<?php
namespace rest\method;

use rest\method;
use handler\http\HttpStatus;
use RedBeanPHP\R;

/**
 * @covers \rest\method\Patch
 */
class PatchTest extends \PHPUnit_Framework_TestCase {
	
	public static function setUpBeforeClass() {
		R::addDatabase(__CLASS__, 'sqlite:'.__DIR__.'/PutTest.sqlite');
	}
	
	public function setUp() {
		$_POST = [];
		R::selectDatabase(__CLASS__);
		R::nuke();
	}
	
	private function createEntry() {
		$_POST['name'] = 'name'.rand(1, 1024);
		
		$post = new Post('test');
		$result = $post->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_201_CREATED, $result->getHttpCode(), 'Resource was not created correctly');
		
		$_POST = [];
		
		return $result->getContent()->getObject()->id;
	}
	
	/**
	 * @covers \rest\method\Patch::__construct
	 * @covers \rest\method\Patch::request
	 */
	public function test404() {
		$_POST['name'] = 'name1';
		
		$patch = new Patch('test');
		$result = $patch->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
	}
	
	/**
	 * @covers \rest\method\Patch::__construct
	 * @covers \rest\method\Patch::request
	 */
	public function test404IdNotFound() {
		$_POST['name'] = 'name1';
	
		$patch = new Patch('test');
		$result = $patch->request(['id'=>4]);
	
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_404_NOT_FOUND, $result->getHttpCode());
	}
	
	
	/**
	 * @covers \rest\method\Patch::__construct
	 * @covers \rest\method\Patch::request
	 */
	public function test200WithID() {
		$id = $this->createEntry(1);
		
		$_POST['name'] = 'name2';
		
		$patch = new Patch('test');
		$result = $patch->request(['id'=>$id]);
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_200_OK, $result->getHttpCode());
	}
	
	/**
	 * @covers \rest\method\Patch::__construct
	 * @covers \rest\method\Patch::request
	 */
	public function test204() {
		$_POST = [];
		
		$patch = new Patch('test');
		$result = $patch->request();
		
		$this->assertTrue($result instanceof \handler\http\HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_204_NO_CONTENT, $result->getHttpCode());
		$this->assertNull($result->getExtraHeaders(), 'Extra headers should be null');
		$this->assertnull($result->getContent(), 'Content should be null');
	}
}
