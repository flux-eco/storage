<?php

namespace fluxStorage;

use FluxEco\Storage;

function deleteStorage(string $tableName, array $jsonSchema, string $envPrefix = '') : void
{
    Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->deleteStorage();
}