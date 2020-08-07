<?php

declare(strict_types=1);

namespace Application;

require_once('src/Utils/debug.php');
require_once('src/View.php');

const DEFAULT_ACTION = 'list';

$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];
if ($action === 'create') {
   $page = 'create';
   $viewParams['resultCreate'] = 'created a new note';
} else {
   $page = 'list';
   $viewParams['resultList'] = 'listed the notes';
}

$view->render($page, $viewParams);
