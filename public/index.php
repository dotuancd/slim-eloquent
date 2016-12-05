<?php

require_once __DIR__  . '/../vendor/autoload.php';

use Slim\App as Application;



$app = new Application();
require_once __DIR__ . '/../app/routes.php';

//require_once __DIR__ . '/../app/Bootstrap.php';
$boostraper = new \App\Bootstrap();
$boostraper->boot();

$app->run();