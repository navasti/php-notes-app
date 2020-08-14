<?php

declare(strict_types=1);

namespace Application;

use Application\Exceptions\AppException;
use Application\Exceptions\ConfigurationException;
use Throwable;

require_once('src/Utils/debug.php');
require_once('src/Controller.php');

$configuration = require_once('config/config.php');

$request = [
   'get' => $_GET,
   'post' => $_POST
];

try {
   Controller::initConfiguration($configuration);
   $controller = new Controller($request);
   $controller->run();
} catch (ConfigurationException $error) {
   echo "<h1>ErrorConfigurationException</h1>";
   echo "<h3>Configuration error. Contact your administrator</h3>";
} catch (AppException $error) {
   echo "<h1>ErrorAppException</h1>";
   echo "<h3>" . $error->getMessage() . "</h3>";
} catch (Throwable $error) {
   echo "<h1>ErrorThrowable</h1>";
}
