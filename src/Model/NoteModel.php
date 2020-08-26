<?php

declare(strict_types=1);

namespace Application\Model;

use PDO;
use Throwable;
use Application\Exceptions\StorageException;
use Application\Exceptions\NotFoundException;

class NoteModel extends AbstractModel implements ModelInterface
{
   public function list(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array
   {
      return $this->findBy(null, $pageNumber, $pageSize, $sortBy, $sortOrder);
   }

   public function search(string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array
   {
      return $this->findBy($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
   }

   public function count(): int
   {
      try {
         $query = "SELECT count(*) AS cn FROM notes";
         $result = $this->connection->query($query);
         $result = $result->fetch(PDO::FETCH_ASSOC);
         if ($result === false) {
            throw new StorageException("Failed attempt to retrieve the number of notes");
         }
         return (int) $result['cn'];
      } catch (Throwable $error) {
         throw new StorageException("Couldn't get the number of the notes", 400, $error);
      }
   }

   public function get(int $id): array
   {
      try {
         $query = "SELECT * FROM notes WHERE id=$id";
         $result = $this->connection->query($query);
         $note = $result->fetch(PDO::FETCH_ASSOC);
      } catch (Throwable $error) {
         throw new StorageException("Couldn't fetch this note", 400, $error);
      }

      if (!$note) {
         throw new NotFoundException("Note with this id doesn't exist");
         exit("No such note");
      }

      return $note;
   }

   public function searchCount(string $phrase): int
   {
      try {
         $phrase = $this->connection->quote('%' . $phrase . '%', PDO::PARAM_STR);
         $query = "SELECT count(*) AS cn FROM notes WHERE title LIKE($phrase)";
         $result = $this->connection->query($query);
         $result = $result->fetch(PDO::FETCH_ASSOC);
         if ($result === false) {
            throw new StorageException("Failed attempt to retrieve the number of notes");
         }
         return (int) $result['cn'];
      } catch (Throwable $error) {
         throw new StorageException("Couldn't get the number of the notes", 400, $error);
      }
   }

   public function create($data): void
   {
      try {
         echo "Creating a new note";
         $title = $this->connection->quote($data['title']);
         $description = $this->connection->quote($data['description']);
         $created = $this->connection->quote(date('Y-m-d H:i:s'));
         $query = "INSERT INTO notes(title, description, created) 
         VALUES($title, $description, $created)";
         $this->connection->exec($query);
      } catch (Throwable $error) {
         throw new StorageException('Failed to add a new note', 400, $error);
         exit;
      }
   }

   public function delete(int $id): void
   {
      try {
         $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
         $this->connection->exec($query);
      } catch (Throwable $error) {
         throw new StorageException("Couldn't delete the note", 400, $error);
      }
   }

   public function edit(int $id, array $data): void
   {
      try {
         $title = $this->connection->quote($data['title']);
         $description = $this->connection->quote($data['description']);
         $query =  "
            UPDATE notes
            SET title = $title, description = $description
            WHERE id = $id
         ";
         $this->connection->exec($query);
      } catch (Throwable $error) {
         throw new StorageException("Couldn't update the note", 400, $error);
      }
   }

   private function findBy(?string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array
   {
      try {
         $limit = $pageSize;
         $offset = ($pageNumber - 1) * $pageSize;
         if (!in_array($sortBy, ['created', 'title'])) {
            $sortBy = 'title';
         }
         if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
         }

         $wherePart = '';
         if ($phrase) {
            $phrase = $this->connection->quote('%' . $phrase . '%', PDO::PARAM_STR);
            $wherePart = "WHERE title LIKE ($phrase)";
         }

         $query = "
            SELECT id, title, created 
            FROM notes
            $wherePart
            ORDER BY $sortBy $sortOrder
            LIMIT  $offset, $limit
         ";
         $result = $this->connection->query($query);
         $note = $result->fetchAll(PDO::FETCH_ASSOC);
         return $note;
      } catch (Throwable $error) {
         throw new StorageException("Couldn't fetch the notes", 400, $error);
      }
   }
}
