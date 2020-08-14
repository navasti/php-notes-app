<?php

declare(strict_types=1);

namespace Application;

require_once('Exceptions\StorageException.php');

use Application\Exceptions\ConfigurationException;
use Application\Exceptions\StorageException;
use PDO;
use PDOException;
use Throwable;

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

   public function createNote($data): void
   {
      try {
         echo "Creating a new note";
         $title = $this->connection->quote($data['title']);
         $description = $this->connection->quote($data['description']);
         $created = $this->connection->quote(date('Y-m-d H:i:s'));
         $query = "INSERT INTO notes(title, description, created) 
         VALUES($title, $description, $created)";
         $result = $this->connection->exec($query);
      } catch (Throwable $error) {
         throw new StorageException('Failed to add a new note', 400);
         exit;
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
