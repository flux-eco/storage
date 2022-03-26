<?php

namespace FluxEco\Storage\Core\Application\Handlers;

class UpdateDataCommand implements Command
{

    private array $filter;
    private array $dataToRecord;

    private function __construct(array $filter, array $dataToRecord)
    {
        $this->filter = $filter;
        $this->dataToRecord = $dataToRecord;
    }

    public static function new(array $filter, array $dataToRecord): self
    {
        return new self($filter, $dataToRecord);
    }


    public function getDataToRecord(): array
    {
        return $this->dataToRecord;
    }

    final public function getFilter(): array
    {
        return $this->filter;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}