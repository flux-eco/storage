<?php

namespace FluxEco\Storage\Adapters;

use FluxEco\Storage\Adapters\MySqlDatabase\DatabaseConfig;
use FluxEco\Storage\Adapters;
use FluxEco\Storage\Env;
use FluxEco\Storage\Core;

class Config implements Core\Ports\Config
{
    private string $databaseName;
    private string $tableName;
    private array $jsonSchema;
    private Core\Ports\Database\DatabaseClient $databaseClient;

    private function __construct(
        string $databaseName,
        string $tableName,
        array $jsonSchema,
        Core\Ports\Database\DatabaseClient $databaseClient
    ) {
        $this->databaseName = $databaseName;
        $this->tableName = $tableName;
        $this->jsonSchema = $jsonSchema;
        $this->databaseClient = $databaseClient;
    }

    public static function newFromEnv(string $tableName, array $jsonSchema, string $envPrefix = '') : self
    {
        $apiEnv = Env::new($envPrefix);
        $databaseConfig = Adapters\MySqlDatabase\DatabaseConfig::new(
            $apiEnv->getHost(),
            $apiEnv->getDriver(),
            $apiEnv->getName(),
            $apiEnv->getUser(),
            $apiEnv->getPassword()
        );

        $databaseClient = Adapters\MySqlDatabase\MysqlDatabaseClient::new(
            $tableName,
            $jsonSchema,
            $databaseConfig
        );

        return new self($apiEnv->getName(), $tableName, $jsonSchema, $databaseClient);
    }


    public function getDatabaseName() : string
    {
        return $this->databaseName;
    }

    public function getTableName() : string
    {
        return $this->tableName;
    }

    public function getDatabaseClient() : Core\Ports\Database\DatabaseClient
    {
        return $this->databaseClient;
    }

    final public function getJsonSchema() : array
    {
        return $this->jsonSchema;
    }
}