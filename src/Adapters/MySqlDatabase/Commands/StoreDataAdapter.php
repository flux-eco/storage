<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase\Commands;

use FluxEco\Storage\Core\Application;

class StoreDataAdapter
{
    private const TYPE_BOOLEAN = 'boolean';

    private array $jsonSchema;
    private array $data;
    private array $filter;

    private function __construct(array $jsonSchema, array $data, array $filter = [])
    {
        $this->jsonSchema = $jsonSchema;
        $this->data = $data;
        $this->filter = $filter;
    }

    public static function fromApplicationCommand(array $jsonSchema, Application\Handlers\AppendDataCommand|Application\Handlers\UpdateDataCommand $command): self
    {
        $data = $command->getDataToRecord();
        $filter = [];
        if (method_exists($command, 'getFilter')) {
            $filter = $command->getFilter();
        }

        return new self($jsonSchema, $data, $filter);
    }

    public function getData(): array
    {
        $schemaProperties = $this->jsonSchema['properties'];
        $storageData = $this->data;
        foreach ($schemaProperties as $key => $property) {
            if (array_key_exists($key, $storageData) && $property['type'] === self::TYPE_BOOLEAN) {
                if ($storageData[$key] === 'true') {
                    $storageData[$key] = 1;
                }
                if ($storageData[$key] === 'false') {
                    $storageData[$key] = 0;
                }
            }
        }
        return $storageData;
    }

    final public function getFilter(): array
    {
        return $this->filter;
    }


}