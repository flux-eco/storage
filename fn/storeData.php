<?php

namespace fluxStorage;

use FluxEco\Storage;

function storeData(string $tableName, array $jsonSchema, string $envPrefix = '', array $filter = [], array $data = []) : void
{
    Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->storeData($filter, $data);
}