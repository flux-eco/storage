<?php

namespace FluxEco\Storage\Core\Application\Handlers;

use FluxEco\Storage\Core\Ports\Database\DatabaseClient;

class StorageExistsHandler implements Handler
{
    private DatabaseClient $databaseClient;

    private function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public static function new(DatabaseClient $databaseClient): self
    {
        return new self($databaseClient);
    }

    final public function handle(Command|StorageExistsCommand $command): bool
    {
        return $this->databaseClient->storageExists($command);
    }
}