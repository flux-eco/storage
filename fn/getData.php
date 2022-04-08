<?php

namespace fluxStorage;

use FluxEco\Storage;

function getData(string $tableName, array $jsonSchema, string $envPrefix = '', array $filter = [], int $limit = 0, ?string $orderBy = null) : array
{
    return Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->getData($filter, $limit, $orderBy);
}