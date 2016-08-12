<?php
namespace resource;

interface IRestResource {
	public function get();
	public function options();
}