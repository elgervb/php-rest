<?php
namespace test;

use \handler\http\HttpStatus;

abstract class RestMethodTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Creates a new resource
	 * @param string $resourceName
	 * 
	 * @return \RedBeanPHP\OODBBean
	 */
	protected function createResource($resourceName) {
		$postBackup = $_POST;
		$_post = [];
		$_POST['name'] = 'name'.rand(1, 1024);
	
		$post = new \rest\method\Post($resourceName);
		$result = $post->request();
	
		$this->assertTrue($result instanceof HttpStatus, '$result instanceof ' . get_class($result));
		$this->assertEquals(HttpStatus::STATUS_201_CREATED, $result->getHttpCode(), 'Resource was not created correctly');
	
		$_POST = $postBackup;
	
		return $result->getContent()->getObject();
	}
	
}