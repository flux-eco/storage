<?php

namespace FluxEco\Storage;

use FluxEco\Storage\Adapters;
use FluxEco\Storage\Core\Domain;

class JoinOperationRequest
{
    private string $foreignTableName;
    private string $joinExpression;
    private Adapters\MySqlDatabase\Operations\JoinTypeEnum $joinType;

    private function __construct(
        string $foreignTableName,
        string $joinExpression,
        Adapters\MySqlDatabase\Operations\JoinTypeEnum $joinType
    ) {
        $this->foreignTableName = $foreignTableName;
        $this->joinExpression = $joinExpression;
        $this->joinType = $joinType;
    }

    public static function newInnerJoin(string $foreignTableName, string $joinExpression) : self
    {
        return new self(
            $foreignTableName,
            $joinExpression,
            Adapters\MySqlDatabase\Operations\JoinTypeEnum::newInnerJoin()
        );
    }

    public function toDomain() : Domain\Models\JoinOperation
    {
        return Domain\Models\JoinOperation::new($this->foreignTableName, $this->joinExpression, $this->joinType);
    }
}