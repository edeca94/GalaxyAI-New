<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;

class PDOFactory extends Core
{
    private string $dsn;
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->dsn = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);
        $this->username = DB_USER;
        $this->password = DB_PASS;
    }

    public function createPDO(): PDO
    {
        try 
        {
            $pdo = new PDO($this->dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } 
        catch (PDOException $e) 
        {
            throw new Exception(sprintf($this->translator->translate('db_connection_error'), $e->getMessage()));
        }
    }
}