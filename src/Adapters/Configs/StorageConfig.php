<?php

namespace FluxEco\Storage\Adapters\Configs;

use FluxEco\Storage\{Adapters, Core\Ports};

class StorageConfig implements Ports\Configs\StorageConfig
{
    private string $databaseName;
    private string $tableName;
    private array $jsonSchema;
    private DatabaseConfig $databaseConfig;
    private Ports\Database\DatabaseClient $databaseClient;

    private function __construct(
        string                        $databaseName,
        string                        $tableName,
        array                         $jsonSchema,
        DatabaseConfig                $databaseConfig,
        Ports\Database\DatabaseClient $databaseClient
    )
    {
        $this->databaseName = $databaseName;
        $this->tableName = $tableName;
        $this->jsonSchema = $jsonSchema;
        $this->databaseConfig = $databaseConfig;

        $this->databaseClient = $databaseClient;
    }

    public static function new(string $databaseName, string $tableName, array $jsonSchema): self
    {
        $databaseConfig = DatabaseConfig::fromEnvironmentVariables(strtoupper($databaseName));

        $databaseClient = Adapters\MySqlDatabase\MysqlDatabaseClient::new(
            $tableName,
            $jsonSchema,
            $databaseConfig
        );

        return new self($databaseName, $tableName, $jsonSchema, $databaseConfig, $databaseClient);
    }


    /** @return Ports\Database\TableAsserters */
    public function getTableAsserters(): Ports\Database\TableAsserters
    {
        return Adapters\MySqlDatabase\TableAsserters::new();
    }


    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getDatabaseClient(): Ports\Database\DatabaseClient
    {
        return $this->databaseClient;
    }

    final public function getJsonSchema(): array
    {
        return $this->jsonSchema;
    }
}