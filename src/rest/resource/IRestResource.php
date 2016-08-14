<?php
namespace rest\resource;

interface IRestResource {
	public function get(array $params = null);
	public function options(array $params = null);
	public function post(array $params = null);
}