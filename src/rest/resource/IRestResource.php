<?php
namespace rest\resource;

interface IRestResource {
	/**
	 * Returns the resource name
	 *
	 * @return string the resource name
	 */
	public function getResourceName();
	public function delete(array $params = null);
	public function get(array $params = null);
	public function head(array $params = null);
	public function options(array $params = null);
	public function patch(array $params = null);
	public function post(array $params = null);
	public function put(array $params = null);
}