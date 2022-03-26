<?php


namespace FluxEco\Storage\Adapters\Configs;
use FluxEco\Storage\Adapters;
use FluxEco\Storage\Core\Ports;
use FluxEco\Storage\Core\Ports\Configs\StorageConfig;

class Config implements StorageConfig
{

    private string $tableName;
    private DatabaseConfig $databaseConfig;
    private StorageConfig $recordDataProcessConfig;
    private Adapters\MySqlDatabase\Commands\CreateTableHandler $createStorageHandler;


    private function __construct(
        string                                    $tableName,
        DatabaseConfig                            $databaseConfig,
        StorageConfig                             $recordDataProcessConfig,
        Ports\Database\Comands\CreateTableHandler $createStorageHandler
    )
    {
        $this->databaseConfig = $databaseConfig;
        $this->recordDataProcessConfig = $recordDataProcessConfig;
        $this->createStorageHandler = $createStorageHandler;
    }

    public static function new(
        string $databaseName,
        string $tableName
    ): self
    {
        $databaseConfig = DatabaseConfig::fromEnvironmentVariables($databaseName);
        $recordDataProcessConfig = StorageConfig::new($tableName, $databaseConfig);

        $createStorageHandler = Adapters\MySqlDatabase\Commands\CreateTableHandler::new($databaseConfig);

        return new self($tableName, $databaseConfig, $recordDataProcessConfig, $createStorageHandler);
    }


    public function getDatabaseConfig(): DatabaseConfig
    {
        return $this->databaseConfig;
    }

    public function getRecordDataProcessConfig(): StorageConfig
    {
        return $this->recordDataProcessConfig;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseConfig->getDatabase();
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getTableAsserters(): array
    {
        // TODO: Implement getColumnNameAsserters() method.
    }

    public function getCreateStorageHandler(): Ports\Database\Comands\CreateTableHandler
    {
        // TODO: Implement getCreateStorageHandler() method.
    }

    public function getDatabaseClient(): Ports\Database\Comands\StoreInDatabaseHandler
    {
        // TODO: Implement getStoreInDatabaseHandler() method.
    }
}