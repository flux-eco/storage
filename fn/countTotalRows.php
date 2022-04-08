<?php

namespace fluxStorage;

use FluxEco\Storage;

function countTotalRows(string $tableName, array $jsonSchema, string $envPrefix = '', array $filter = [], $limit = 0) : int
{
    return Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->countTotalRows($filter, $limit);
}