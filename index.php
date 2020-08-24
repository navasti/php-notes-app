<?php

declare(strict_types=1);

namespace Application;

spl_autoload_register(function (string $classNamespace) {
   $path = str_replace(['\\', 'Application/'], ['/', ''], $classNamespace);
   $path = "src/$path.php";
   require_once($path);
});

require_once("src/Utils/debug.php");

use Application\Request;
use Application\Exceptions\AppException;
use Application\Controllers\NoteController;
use Application\Controllers\AbstractController;
use Application\Exceptions\ConfigurationException;

$configuration = require_once('config/config.php');

$request = new Request($_GET, $_POST);

try {
   AbstractController::initConfiguration($configuration);
   $noteController = new NoteController($request);
   $noteController->run();
} catch (ConfigurationException $error) {
   echo "<h1>Configuration Error</h1>";
   echo "<h3>Configuration error. Contact your administrator</h3>";
} catch (AppException $error) {
   echo "<h1>Application Error</h1>";
   echo "<h3>" . $error->getMessage() . "</h3>";
} catch (\Throwable $error) {
   echo "<h1>Error</h1>";
   echo "<h3>" . $error->getMessage() . "</h3>";
}
