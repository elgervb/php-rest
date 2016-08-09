<?php
use RedBeanPHP\R;

include __DIR__ . '/../vendor/autoload.php';

// all dates in UTC timezone
date_default_timezone_set("UTC");

// setup database
R::setup('sqlite:./db.sqlite');

phpinfo();
