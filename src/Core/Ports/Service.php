<?php

namespace FluxEco\Storage\Core\Ports;

use FluxEco\Storage\Core\{Application, Ports};

class Service
{
    private Ports\Outbounds $outbounds;

    private function __construct(
        Ports\Outbounds $outbounds
    ) {
        $this->outbounds = $outbounds;
    }

    public static function new(Ports\Outbounds $outbounds) : self
    {
        return new self(
            $outbounds
        );
    }

    final public function createStorage(?string $primaryKey = null) : void
    {
        if ($this->storageExists() === true) {
            return;
        }
        $storage = $this->buildStorageTable($primaryKey);

        $command = Application\Handlers\CreateStorageCommand::new($storage);
        Application\Handlers\CreateStorageHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }

    final public function deleteStorage() : void
    {
        if ($this->storageExists() === false) {
            return;
        }
        $tableName = $this->outbounds->getConfig()->getTableName();
        $command = Application\Handlers\DeleteStorageCommand::new($tableName);
        Application\Handlers\DeleteStorageHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }

    private function storageExists() : bool
    {
        $tableName = $this->outbounds->getConfig()->getTableName();
        $command = Application\Handlers\StorageExistsCommand::new($tableName);
        return Application\Handlers\StorageExistsHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }

    private function buildStorageTable(
        ?string $primaryKey = null
    ) : Ports\Database\Table {
        $tableName = $this->outbounds->getConfig()->getTableName();
        $jsonSchema = $this->outbounds->getConfig()->getJsonSchema();

        $dataStorageBuilder = Application\Builders\TableBuilder::new(
            $tableName
        );

        foreach ($jsonSchema['properties'] as $key => $propertySchema) {
            $dataStorageBuilder->addColumnFromSchema($key, $propertySchema);
        }

        if ($primaryKey !== null) {
            $dataStorageBuilder->addPrimaryKey($primaryKey);
        }

        return $dataStorageBuilder->build();
    }

    public function storeData(array $filter, array $data) : void
    {
        $result = $this->getData($filter);
        if (count($result) === 1) {
            $command = Application\Handlers\UpdateDataCommand::new($filter, $data);
            Application\Handlers\UpdateDataHandler::new($this->outbounds->getDatabaseClient())->handle($command);
            return;
        }
        $this->appendData($data);
    }

    public function appendData(array $data) : void
    {
        $command = Application\Handlers\AppendDataCommand::fromArray($data);
        Application\Handlers\AppendDataHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }

    public function deleteData(array $filter) : void
    {
        $this->outbounds->getDatabaseClient()->deleteData($filter);
    }

    public function getData(array $filter, int $limit = 0, ?string $orderBy = null) : array
    {
        $command = Application\Handlers\GetDataCommand::new($filter, $limit, $orderBy);
        return Application\Handlers\GetDataHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }

    public function countRows(array $filter, int $limit = 0) : int
    {
        $command = Application\Handlers\CountDataCommand::new($filter, $limit);
        return Application\Handlers\CountDataHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }
}