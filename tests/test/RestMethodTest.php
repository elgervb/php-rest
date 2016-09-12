<?php
namespace test;

use \handler\http\HttpStatus;
use RedBeanPHP\OODBBean;

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
	
	/**
	 * Finds a resource by it's ID
	 * @param string $resourceType
	 * @param int $id
	 * @return \RedBeanPHP\OODBBean or null when not found
	 */
	protected function findByID($resourceType, $id) {
		return \RedBeanPHP\R::findOne($resourceType, 'id = ?', [$id]);;
	}
	
	protected function assertFindByID($resourceType, $id) {
		$resource = $this->findByID($resourceType, $id);
	
		$this->assertTrue($resource instanceof OODBBean);
		$this->assertEquals($id, $resource->id);
	}
}
