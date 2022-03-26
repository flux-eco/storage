<?php


namespace FluxEco\Storage\Core\Application\Handlers;

use FluxEco\Storage\Core\Ports;

class CreateStorageCommand implements Command
{

    private Ports\Database\Table $storage;

    private function __construct(Ports\Database\Table $storage)
    {
        $this->storage = $storage;
    }

    public static function new(
        Ports\Database\Table $storage
    ): self
    {
        return new self($storage);
    }


    public function getStorage(): Ports\Database\Table
    {
        return $this->storage;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}