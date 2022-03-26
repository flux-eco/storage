<?php
namespace FluxEco\Storage\Core\Application\Handlers;
use FluxEco\Storage\Core\Ports\Database\DatabaseClient;

class CreateStorageHandler implements Handler
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

    public function handle(Command|CreateStorageCommand $command): void
    {
        $this->databaseClient->createStorage($command);
    }
}