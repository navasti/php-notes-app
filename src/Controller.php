<?php

declare(strict_types=1);

namespace Application;

require_once('src/Database.php');
require_once('src/View.php');

class Controller
{
   private const DEFAULT_ACTION = 'list';

   private static array $configuration = [];

   private array $request;
   private View $view;

   public static function initConfiguration(array $configuration): void
   {
      self::$configuration = $configuration;
   }

   public function __construct(array $request)
   {
      $db = new Database(self::$configuration['db']);

      $this->request = $request;
      $this->view = new View();
   }

   public function run(): void
   {
      $viewParams = [];

      switch ($this->action()) {
         case 'create':
            $page = 'create';
            $created = false;
            $data = $this->getRequestPost();
            if (!empty($data)) {
               $created = true;
               $viewParams = [
                  'title' => $data['title'],
                  'description' => $data['description']
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

      $this->view->render($page, $viewParams);
   }

   private function action(): string
   {
      $data = $this->getRequestGet();
      return $data['action'] ?? self::DEFAULT_ACTION;
   }

   private function getRequestPost(): array
   {
      return $this->request['post'] ?? [];
   }

   private function getRequestGet(): array
   {
      return $this->request['get'] ?? [];
   }
}
