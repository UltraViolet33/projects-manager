<?php

namespace App\Models;

use App\Core\Database\Database;

abstract class Model
{
    protected Database $db;
    protected string $table;
    protected string $id;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = $this->setTableName();
        $this->id = $this->setId();
    }


    // abstract protected function create(array $data): bool;

    // abstract protected function update(array $data): bool;


    public function selectOneById(int $id): object
    {
        $query = "SELECT * FROM $this->table WHERE $this->id = :id";
        return $this->db->readOneRow($query, ["id" => $id]);
    }

    public function selectByColumn(string $column, mixed $value): object|bool
    {
        $query = "SELECT * FROM $this->table WHERE $column = :value";
        return $this->db->readOneRow($query, ["value" => $value]);
    }


    public function doesExist(string $arg, mixed $value): bool
    {
        $query = "SELECT * FROM $this->table WHERE $arg = :value";
        $result = $this->db->readOneRow($query, ["value" => $value]);

        return $result ? true : false;
    }


    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table";
        return $this->db->read($query);
    }


    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE $this->id = :id";
        return $this->db->write($query, ["id" => $id]);
    }


    private function setTableName(): string
    {
        $table = get_class($this);
        return strtolower(explode("\\", get_class($this))[2] . 's');
    }

    private function setId(): string
    {
        $table = get_class($this);
        $table = strtolower(explode("\\", get_class($this))[2]);
        return "id_" . $table;
    }
}
