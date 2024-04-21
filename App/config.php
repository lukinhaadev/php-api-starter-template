<?php

use \Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));

$dotenv->load();

date_default_timezone_set($_ENV['TIMEZONE']);
define("BASEDIR", dirname(__FILE__, 2));