<?php

declare(strict_types=1);

namespace Application\Model;

use PDO;
use PDOException;
use Application\Exceptions\StorageException;
use Application\Exceptions\ConfigurationException;

abstract class AbstractModel
{
   protected PDO $connection;

   public function __construct(array $config)
   {
      try {
         $this->validateConfig($config);
         $this->createConnection($config);
      } catch (PDOException $error) {
         throw new StorageException('Connection error');
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
