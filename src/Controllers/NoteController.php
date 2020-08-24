<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Exceptions\NotFoundException;

class NoteController extends AbstractController
{
   public function createAction()
   {
      if ($this->request->hasPost()) {
         $this->database->createNote([
            'title' => $this->request->postParam('title'),
            'description' => $this->request->postParam('description')
         ]);
         $this->redirect('/', ['before' => 'created']);
      }
      $this->view->render('create');
   }
   public function showAction()
   {
      $noteId = (int) $this->request->getParam('id');
      if (!$noteId) {
         $this->redirect('/', ['error' => 'missingNoteId']);
      }
      try {
         $note = $this->database->getNote($noteId);
      } catch (NotFoundException $error) {
         $this->redirect('/', ['error' => 'noteNotFound']);
      }
      $this->view->render(
         'show',
         ['note' => $note]
      );
   }
   public function listAction()
   {
      $this->view->render(
         'list',
         [
            'notes' => $this->database->getNotes(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error'),
         ]
      );
   }

   public function editAction()
   {
      if ($this->request->isPost()) {
         $noteId = (int) $this->request->postParam('id');
         $noteData = [
            'title' => $this->request->postParam('title'),
            'description' => $this->request->postParam('description'),
         ];
         $this->database->editNote($noteId, $noteData);
         $this->redirect('/', ['before' => 'edited']);
      }
      $noteId = (int) $this->request->getParam('id');
      if (!$noteId) {
         $this->redirect('/', ['error' => 'missingNoteId']);
      }
      try {
         $note = $this->database->getNote($noteId);
      } catch (NotFoundException $error) {
         $this->redirect('/', ['error' => 'noteNotFound']);
      }
      $this->view->render('edit', ['note' => $note]);
   }
}
