<?php

namespace fluxStorage;

use FluxEco\Storage;

function getData(string $tableName, array $jsonSchema, string $envPrefix = '', array $filter = [], int $sequenceOffSet = 0, int $limit = 0, ?string $orderBy = null) : array
{
    return Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->getData($filter, $sequenceOffSet, $limit, $orderBy);
}