<?php

namespace FluxEco\Storage\Core\Domain;

class Table implements \FluxEco\Storage\Core\Ports\Database\Table
{
    private string $tableName;
    private ?string $primaryKey;
    private array $uniqueKey = [];
    private array $columns = [];


    private function __construct(
        string $tableName,
        array  $columns,
        ?string $primaryKey,
        array  $uniqueKey = []
    )
    {
        $this->tableName = $tableName;
        $this->columns = $columns;
        $this->primaryKey = $primaryKey;
        $this->uniqueKey = $uniqueKey;
    }


    public static function new(
        string  $tableName,
        array   $columns,
        ?string $primaryKey = null,
        array   $uniqueKey
    ): self
    {
        self::asssertUniqueKeyColumnExists($uniqueKey, $columns);
        if ($primaryKey !== null) {
            self::asssertPrimaryKeyColumnExists($primaryKey, $columns);
        }

        return new self(
            $tableName,
            $columns,
            $primaryKey,
            $uniqueKey
        );
    }


    private static function asssertPrimaryKeyColumnExists(string $primaryKey, array $columns): void
    {
        if (!array_key_exists($primaryKey, $columns)) {
            throw new \RuntimeException('Primary ' . $primaryKey . ' key does not exists in columns');
        }
    }

    private static function asssertUniqueKeyColumnExists(array $uniqueKey, array $columns): void
    {
        foreach ($uniqueKey as $columnName) {
            if (!array_key_exists($columnName, $columns)) {
                throw new \RuntimeException('UniqueKey: ' . $columnName . 'key does not exists in columns');
            }
        }
    }

    final public function getTableName(): string
    {
        return $this->tableName;
    }



    final public function getPrimaryKey(): string|null
    {
        return $this->primaryKey;
    }


    final public function getUniqueKey(): array
    {
        return $this->uniqueKey;
    }

    /**
     * @return \FluxEco\Storage\Core\Ports\Database\Models\Column[]
     */
    final public function getColumns(): array
    {
        return $this->columns;
    }
}