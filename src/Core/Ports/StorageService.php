<?php


namespace FluxEco\Storage\Core\Ports;

use FluxEco\Storage\Core\{Application, Ports};

class StorageService
{
    private Ports\Database\DatabaseClient $databaseClient;
    private Ports\Database\TableAsserters $asserters;

    private function __construct(
        Ports\Database\DatabaseClient $databaseClient,
        Ports\Database\TableAsserters $asserters,
    )
    {
        $this->databaseClient = $databaseClient;
        $this->asserters = $asserters;
    }

    public static function new(Configs\StorageConfig $storageConfig): self
    {
        return new self(
            $storageConfig->getDatabaseClient(),
            $storageConfig->getTableAsserters(),
        );
    }


    final public function createStorage(string $tableName, array $jsonSchema, ?string $primaryKey = null, bool $allowIncompleteRows = false): void
    {
        if ($this->storageExists($tableName) === true) {
            return;
        }
        $storage = $this->buildStorageTable($tableName, $jsonSchema, $primaryKey, $allowIncompleteRows);

        $command = Application\Handlers\CreateStorageCommand::new($storage);
        Application\Handlers\CreateStorageHandler::new($this->databaseClient)->handle($command);
    }

    final public function deleteStorage(string $tableName): void
    {
        $command = Application\Handlers\DeleteStorageCommand::new($tableName);
        Application\Handlers\DeleteStorageHandler::new($this->databaseClient)->handle($command);
    }

    private function storageExists(string $tableName): bool
    {
        $command = Application\Handlers\StorageExistsCommand::new($tableName);
        return Application\Handlers\StorageExistsHandler::new($this->databaseClient)->handle($command);
    }

    private function buildStorageTable(string $tableName, array $jsonSchema, ?string $primaryKey = null, bool $allowIncompleteRows = false): Ports\Database\Table
    {
        $dataStorageBuilder = Application\Builders\TableBuilder::new(
            $tableName,
            $this->asserters
        );

        foreach ($jsonSchema['properties'] as $key => $propertySchema) {
            $dataStorageBuilder->addColumnFromSchema($key, $propertySchema);
        }

        if ($primaryKey !== null) {
            $dataStorageBuilder->addPrimaryKey($primaryKey);
        }


        return $dataStorageBuilder->build();
    }

    public function storeData(array $filter, array $data): void
    {
        $result = $this->getData($filter);
        if (count($result) === 1) {
            $command = Application\Handlers\UpdateDataCommand::new($filter, $data);
            Application\Handlers\UpdateDataHandler::new($this->databaseClient)->handle($command);
            return;
        }
        $this->appendData($data);
    }

    public function appendData(array $data): void
    {
        $command = Application\Handlers\AppendDataCommand::fromArray($data);
        Application\Handlers\AppendDataHandler::new($this->databaseClient)->handle($command);
    }

    public function deleteData(array $filter): void
    {
        $this->databaseClient->deleteData($filter);
    }

    public function getData(array $filter, int $limit = 0, ?string $orderBy = null): array
    {
        $command = Application\Handlers\GetDataCommand::new($filter, $limit, $orderBy);
        return Application\Handlers\GetDataHandler::new($this->databaseClient)->handle($command);
    }

    public function countRows(array $filter, int $limit = 0): int
    {
        $command = Application\Handlers\CountDataCommand::new($filter, $limit);
        return Application\Handlers\CountDataHandler::new($this->databaseClient)->handle($command);
    }
}