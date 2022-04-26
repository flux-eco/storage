<?php

namespace fluxStorage;

use FluxEco\Storage;

function getData(
    string $tableName,
    array $jsonSchema,
    string $envPrefix = '',
    ?array $filter = null, ?int $offset = null, ?int $limit = null, ?string $orderBy = null, ?string $search = null
) : array {
    $joinOperations = [];
    if (key_exists('joins', $jsonSchema) && count($jsonSchema['joins']) > 0) {
        foreach ($jsonSchema['joins'] as $join) {
            $joinOperations[] = Storage\JoinOperationRequest::newInnerJoin(
                $join['foreignTableName'],
                $join['joinExpression']
            );
        }
    }
    return Storage\Api::newFromEnv($tableName, $jsonSchema, $envPrefix)->getData($filter, $offset, $limit, $orderBy, $search, $joinOperations);
}