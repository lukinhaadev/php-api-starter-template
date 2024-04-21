<?php

use App\Modules\Router;

require_once '..\\vendor\\autoload.php';
require_once 'autoload.php';
require_once 'config.php';
require_once 'routes.php';

Router::listen();