<?php

declare(strict_types=1);

namespace Application;

require_once('src/View.php');

class Controller
{
   private const DEFAULT_ACTION = 'list';

   private $postData;
   private $getData;

   public function __construct(array $getData, array $postData)
   {
      $this->getData = $getData;
      $this->postData = $postData;
   }

   public function run(): void
   {
      $action = $this->getData['action'] ?? self::DEFAULT_ACTION;

      $view = new View();
      $viewParams = [];

      switch ($action) {
         case 'create':
            $page = 'create';
            $created = false;
            if (!empty($this->postData)) {
               $created = true;
               $viewParams = [
                  'title' => $this->postData['title'],
                  'description' => $this->postData['description']
               ];
            }
            $viewParams['created'] = $created;
            break;
         case 'show':
            $viewParams = [
               'title' => 'My note',
               'description' => 'Description'
            ];
            break;
         default:
            $page = 'list';
            $viewParams['resultList'] = 'listed the notes';
            break;
      }

      $view->render($page, $viewParams);
   }
}
