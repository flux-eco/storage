<?php

namespace fluxStorage;

use FluxEco\Storage;

function deleteData(string $tableName, array $jsonSchema, string $envPrefix = '', array $filter = []) : void
{
    Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->deleteData($filter);
}