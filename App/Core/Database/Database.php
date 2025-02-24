<?php

namespace App\Core;

use Exception;
use PDO;
use PDOStatement;
use PDOException;

class Database extends Core
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        Core::__construct();

        $this->pdo = $pdo;
        $this->translator = new Translator($this->getUserLanguage());
    }

    public function executeQuery(string $query, array $params = []): PDOStatement
    {
        try
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $statement;
        }
        catch (PDOException $e)
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function fetchSingle(string $query, array $params = []): ?array
    {
        try
        {
            $statement = $this->executeQuery($query, $params);
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function fetchColumn($query, $params = [])
    {
        try
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $statement->fetchColumn();
        }
        catch (PDOException $e)
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function fetchAll(string $query, array $params = []): array
    {
        try
        {
            $statement = $this->executeQuery($query, $params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        try 
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($data);
            return true;
        } 
        catch (PDOException $e) 
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function update(string $table, array $data, string $condition, array $params = []): bool
    {
        $setClause = '';
        
        foreach ($data as $column => $value) 
        {
            $setClause .= "$column = :$column, ";
        }
        $setClause = rtrim($setClause, ', ');

        $query = "UPDATE $table SET $setClause WHERE $condition";

        try
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute(array_merge($data, $params));
            return true;
        }
        catch (PDOException $e) 
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function delete(string $table, string $condition, array $params = []): bool
    {
        $query = "DELETE FROM $table WHERE $condition";

        try 
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return true;
        } 
        catch (PDOException $e) 
        {
            throw new Exception(sprintf($this->translator->translate('db_query_error'), $e->getMessage()));
        }
    }

    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}