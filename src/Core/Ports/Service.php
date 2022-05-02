<?php

namespace FluxEco\Storage\Core\Ports;

use FluxEco\Storage\Core\{Application, Domain};

class Service
{
    private Outbounds $outbounds;

    private function __construct(
        Outbounds $outbounds
    ) {
        $this->outbounds = $outbounds;
    }

    public static function new(Outbounds $outbounds) : self
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
    ) : Database\Table {
        $tableName = $this->outbounds->getConfig()->getTableName();
        $jsonSchema = $this->outbounds->getConfig()->getJsonSchema();

        $dataStorageBuilder = Application\Builders\TableBuilder::new(
            $tableName
        );

        foreach ($jsonSchema['properties'] as $key => $propertySchema) {
            $dataStorageBuilder->addColumnFromSchema($key, $propertySchema);
        }

        if(array_key_exists('fulltextSearch', $jsonSchema)) {
            $dataStorageBuilder->addBlobColumn('fulltextSearch', true);
            $dataStorageBuilder->addIndexes(['fulltextSearch'], 'fulltextSearch');
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

    /**
     * @param ?Database\Models\JoinOperation[] $joinOperations
     * @return array
     */
    public function getData(
        ?array $filter = null,
        ?int $sequenceOffSet = null,
        ?int $limit = null,
        ?string $orderBy = null,
        ?string $search = null,
        ?int $fromSeq = null,
        ?array $joinOperations = null
    ) : array {
        $joinOperationModels = [];
        if (is_null($joinOperations) === false) {
            foreach ($joinOperations as $joinOperation) {
                $joinOperationModels[] = $joinOperation->toDomain();
            }
        }


        $command = Application\Handlers\GetDataCommand::new(Domain\Models\Filter::new($filter, $this->outbounds->getConfig()->getJsonSchema()), $sequenceOffSet, $limit, $orderBy, $search, $fromSeq, $joinOperationModels);
        return Application\Handlers\GetDataHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }

    public function countRows(array $filter, int $limit = 0) : int
    {
        $command = Application\Handlers\CountDataCommand::new($filter, $limit);
        return Application\Handlers\CountDataHandler::new($this->outbounds->getDatabaseClient())->handle($command);
    }
}