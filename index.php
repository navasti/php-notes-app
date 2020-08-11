<?php

declare(strict_types=1);

namespace Application;

require_once('src/Utils/debug.php');
require_once('src/Controller.php');

$configuration = require_once('config/config.php');

$request = [
   'get' => $_GET,
   'post' => $_POST
];

Controller::initConfiguration($configuration);
$controller = new Controller($request);
$controller->run();
