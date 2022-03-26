<?php


namespace FluxEco\Storage\Adapters\Api;

use FluxEco\Storage\Adapters\{Configs};
use FluxEco\Storage\Core\{Ports};

class StorageApi
{
    private Ports\StorageService $service;
    private string $tableName;
    private array $jsonSchema;

    private function __construct(string $tableName,array $jsonSchema, Ports\StorageService $service)
    {
        $this->tableName = $tableName;
        $this->jsonSchema = $jsonSchema;
        $this->service = $service;
    }

    public static function new(
        string $databaseName,
        string $tableName,
        array $jsonSchema
    ): self
    {
        $config = Configs\StorageConfig::new($databaseName, $tableName, $jsonSchema);
        $service = Ports\StorageService::new($config);
        return new self($tableName, $jsonSchema, $service);
    }

    public function storeData(array $filter, array $data): void
    {
        $this->service->storeData($filter, $data);
    }

    public function deleteData(array $filter): void
    {
        $this->service->deleteData($filter);
    }

    public function appendData(array $data): void
    {
        $this->service->appendData($data);
    }

    /**
     * allowIncompleteRows: all columns - except the primary key - are created with the option nullable = true
     */
    final public function createStorage(?string $primaryKey = null, bool $allowIncompleteRows = false): void
    {
        $tableName = $this->tableName;
        $jsonSchema = $this->jsonSchema;
        $this->service->createStorage($tableName, $jsonSchema, $primaryKey, $allowIncompleteRows);
    }

    public function deleteStorage(): void
    {
        $tableName = $this->tableName;
        $this->service->deleteStorage($tableName);
    }

    final public function getData(array $filter, int $limit = 0, ?string $orderBy = null): array
    {
        return $this->service->getData($filter, $limit = 0, $orderBy);
    }

    final public function countTotalRows(array $filter, $limit = 0): int
    {
        return $this->service->countRows($filter, $limit = 0);
    }


}