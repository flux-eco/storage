<?php

namespace FluxEco\Storage\Core\Ports\Database;
use FluxEco\Storage\Core\Application\Handlers;

interface DatabaseClient
{
    public function countData(Handlers\CountDataCommand $countDataCommand): int;
    public function getData(Handlers\GetDataCommand $getDataCommand): array;
    public function deleteData(array $filter): void;
    public function updateData(Handlers\UpdateDataCommand $updateDataCommand): void;
    public function appendData(Handlers\AppendDataCommand $appendDataCommand): void;
    public function createStorage(Handlers\CreateStorageCommand $createStorageCommand): void;
    public function deleteStorage(string $tableName): void;
    public function storageExists(Handlers\StorageExistsCommand $storageExistsCommand): bool;
    public function getJsonSchema(): array;
}