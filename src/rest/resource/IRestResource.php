<?php
namespace rest\resource;

interface IRestResource {
	public function get();
	public function options();
}