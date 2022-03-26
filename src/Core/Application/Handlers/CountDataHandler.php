<?php


namespace FluxEco\Storage\Core\Application\Handlers;

use FluxEco\Storage\Core\Ports\Database\DatabaseClient;

class CountDataHandler
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

    public function handle(CountDataCommand $query): int
    {
        return $this->databaseClient->countData($query);
    }
}