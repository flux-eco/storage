<?php

namespace fluxStorage;

use FluxEco\Storage;

function appendData(string $tableName, array $jsonSchema, array $data, string $envPrefix = '') : void
{
    Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->appendData($data);
}