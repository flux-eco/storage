<?php


namespace FluxEco\Storage\Core\Application\Handlers;

class AppendDataCommand implements Command {

    //Todo ModelData -> key/value with storage definition
    private array $dataToRecord;

    private function __construct(array $dataToRecord) {
        $this->dataToRecord = $dataToRecord;
    }

    public static function fromArray(array $dataToRecord): self {
        return new self($dataToRecord);
    }


    public function getDataToRecord(): array
    {
        return $this->dataToRecord;
    }


    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}