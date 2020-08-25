<?php

declare(strict_types=1);

namespace Application;

use PDO;
use Throwable;
use PDOException;
use Application\Exceptions\StorageException;
use Application\Exceptions\NotFoundException;
use Application\Exceptions\ConfigurationException;

class Database
{
   private PDO $connection;

   public function __construct(array $config)
   {
      try {
         $this->validateConfig($config);
         $this->createConnection($config);
      } catch (PDOException $error) {
         throw new StorageException('Connection error');
      }
   }

   public function getNote(int $id): array
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

   public function getNotes(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array
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
         $query = "
            SELECT id, title, created 
            FROM notes
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

   public function getCount(): int
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

   public function createNote($data): void
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

   public function deleteNote(int $id): void
   {
      try {
         $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
         $this->connection->exec($query);
      } catch (Throwable $error) {
         throw new StorageException("Couldn't delete the note", 400, $error);
      }
   }

   public function editNote(int $id, array $data): void
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

   private function createConnection(array $config): void
   {
      $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
      $this->connection = new PDO(
         $dsn,
         $config['user'],
         $config['password'],
         [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );
   }

   private function validateConfig(array $config): void
   {
      if (
         empty($config['database'])
         || empty($config['host'])
         || empty($config['user'])
         || empty($config['password'])
      ) {
         throw new ConfigurationException('Storage configuration error');
      }
   }
}
