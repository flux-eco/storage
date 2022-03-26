<?php


namespace FluxEco\Storage\Core\Application\Handlers;

use FluxEco\Storage\Core\Ports;

class StorageExistsCommand implements Command
{
    private string $tableName;

    private function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public static function new(
        string $tableName
    ): self
    {
        return new self($tableName);
    }


    public function getTableName(): string
    {
        return $this->tableName;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}