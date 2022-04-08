<?php

namespace fluxStorage;

use FluxEco\Storage;

function createStorage(string $tableName, array $jsonSchema, string $envPrefix = '') : void
{
    Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->createStorage();
}