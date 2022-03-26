<?php

namespace FluxEco\Storage\Core\Application\Handlers;

use FluxEco\Storage\Core\Ports\Database\DatabaseClient;

class UpdateDataHandler implements Handler
{
    private DatabaseClient $databaseClient;
    private array $jsonSchema;

    private function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public static function new(DatabaseClient $databaseClient): self
    {
        return new self($databaseClient);
    }

    public function handle(Command|UpdateDataCommand $command): void
    {
        $this->databaseClient->updateData($command);
    }
}