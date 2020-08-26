<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\View;
use Application\Request;
use Application\Model\NoteModel;
use Application\Exceptions\ConfigurationException;
use Application\Exceptions\NotFoundException;
use Application\Exceptions\StorageException;

abstract class AbstractController
{
   protected const DEFAULT_ACTION = 'list';

   private static array $configuration = [];

   protected NoteModel $noteModel;
   protected Request $request;
   protected View $view;

   public static function initConfiguration(array $configuration): void
   {
      self::$configuration = $configuration;
   }

   public function __construct(Request $request)
   {
      if (empty(self::$configuration['db'])) {
         throw new ConfigurationException('Configuration error');
      }
      $this->noteModel = new NoteModel(self::$configuration['db']);
      $this->request = $request;
      $this->view = new View();
   }

   public function run(): void
   {
      try {
         $action = $this->action() . 'Action';
         if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
         }
         $this->$action();
      } catch (StorageException $error) {
         $this->view->render('error', ['message' => $error->getMessage()]);
      } catch (NotFoundException $error) {
         $this->redirect('/', ['error' => 'noteNotFound']);
      }
   }

   final protected function redirect(string $direction, array $params): void
   {
      $location = $direction;
      if (count($params)) {
         $queryParams = [];
         foreach ($params as $key => $value) {
            $queryParams[] = urlencode($key) . '=' . urlencode($value);
         }
         $queryParams = implode('&', $queryParams);
         $location .= '?' . $queryParams;
      }
      header("Location: $location");
      exit;
   }

   final public function action(): string
   {
      return $this->request->getParam('action', self::DEFAULT_ACTION);
   }
}
