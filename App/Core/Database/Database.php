<?php

namespace App\Core\Database;

use Exception;
use \PDO;

class Database
{

    private ?PDO $PDOInstance = null;
    private static ?self $instance = null;


    private function __construct()
    {
        try {

            $string = Config::getValue('db_type') . ":host=" . Config::getValue('db_host') . ";dbname=" . Config::getValue('db_name');
            $this->PDOInstance  = new PDO($string, Config::getValue('db_user'), Config::getValue('db_password'), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (Exception $e) {

            echo "an error";
            // use global variables to display error
        }
    }


    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }


    public function read(string $query,  array $data = array()): array
    {
        $statement = $this->PDOInstance->prepare($query);
        $statement->execute($data);
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }


    public function readOneRow(string $query, array $data = []): object|bool
    {
        $statement = $this->PDOInstance->prepare($query);
        $statement->execute($data);
        return $statement->fetch(PDO::FETCH_OBJ);
    }


    public function write(string $query, array $data = array())
    {
        $statement = $this->PDOInstance->prepare($query);
        return $statement->execute($data);
    }


    public function getLastInsertId(): int
    {
        return $this->PDOInstance->lastInsertId();
    }
}
