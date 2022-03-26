<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase;
use FluxEco\Storage\Core\Ports;


class TableAdapter implements Ports\Database\Table {

    private Ports\Database\Table $storage;

    private function __construct(Ports\Database\Table $storage) {
        $this->storage = $storage;
    }

    public static function fromDomain(Ports\Database\Table $storage): self {
        return new self($storage);
    }


    final public function getTableName(): string
    {
        return $this->storage->getTableName();
    }

    final public function getPrimaryKey(): array
    {
        return $this->storage->getPrimaryKey();
    }

    final public function getUniqueKey(): ?string
    {
        return $this->storage->getUniqueKey();
    }

    final public function getColumns(): array
    {
        return $this->storage->getColumns();
    }
}