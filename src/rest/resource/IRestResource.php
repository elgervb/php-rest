<?php
namespace rest\resource;

interface IRestResource {
	public function delete(array $params = null);
	public function get(array $params = null);
	public function head(array $params = null);
	public function options(array $params = null);
	public function patch(array $params = null);
	public function post(array $params = null);
	public function put(array $params = null);
}