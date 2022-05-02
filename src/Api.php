<?php

namespace FluxEco\Storage;


class Api
{
    private Core\Ports\Service $service;

    private function __construct(Core\Ports\Config $config)
    {
        $outbounds = Adapters\Outbounds::new($config);
        $service = Core\Ports\Service::new($outbounds);

        $this->service = $service;
    }

    public static function newFromEnv(string $tableName, array $jsonSchema, string $envPrefix = '') : self
    {
        $config = Adapters\Config::newFromEnv($tableName, $jsonSchema, $envPrefix);
        return new self($config);
    }

    public function storeData(array $filter, array $data) : void
    {
        $this->service->storeData($filter, $data);
    }

    public function deleteData(array $filter) : void
    {
        $this->service->deleteData($filter);
    }

    public function appendData(array $data) : void
    {
        $this->service->appendData($data);
    }

    final public function createStorage(?string $primaryKey = null) : void
    {
        $this->service->createStorage($primaryKey);
    }

    public function deleteStorage() : void
    {
        $this->service->deleteStorage();
    }

    final public function getData(?array $filter = null, ?int $sequenceOffSet = null,?int $limit = null, ?string $orderBy = null, ?string $search = null, ?int $fromSeq = null, ?array $joinOperations = null) : array
    {
        return $this->service->getData($filter, $sequenceOffSet, $limit, $orderBy, $search, $fromSeq, $joinOperations);
    }

    final public function countTotalRows(array $filter, $limit = 0) : int
    {
        return $this->service->countRows($filter, $limit = 0);
    }

}