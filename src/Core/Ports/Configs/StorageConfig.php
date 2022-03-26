<?php

namespace FluxEco\Storage\Core\Ports\Configs;

use FluxEco\Storage\Core\Ports;

interface StorageConfig
{
    public function getDatabaseName(): string;

    public function getTableName(): string;

    /** @return Ports\Database\TableAsserters */
    public function getTableAsserters(): Ports\Database\TableAsserters;


    public function getDatabaseClient(): Ports\Database\DatabaseClient;
}