<?php

namespace FluxEco\Storage;

use FluxEco\Storage\Adapters;
use FluxEco\Storage\Core\Domain;
use mysql_xdevapi\Exception;

class JoinOperationRequest
{
    private string $foreignTableName;
    private string $joinExpression;
    private Adapters\MySqlDatabase\Operations\JoinTypeEnum $joinType;

    private function __construct(
        string $foreignTableName,
        string $foreignFields,
        string $joinExpression,
        Adapters\MySqlDatabase\Operations\JoinTypeEnum $joinType
    ) {
        $this->foreignTableName = $foreignTableName;
        $this->foreignFields = $foreignFields;
        $this->joinExpression = $joinExpression;
        $this->joinType = $joinType;
    }

    public static function fromSchema(string $foreignTableName, string $foreignFields, string $joinType, string $joinExpression) {
        switch($joinType) {
            case 'innerJoin':
                return new self(
                    $foreignTableName,
                    $foreignFields,
                    $joinExpression,
                    Adapters\MySqlDatabase\Operations\JoinTypeEnum::newInnerJoin()
                );
            case 'leftJoin':
                return new self(
                    $foreignTableName,
                    $foreignFields,
                    $joinExpression,
                    Adapters\MySqlDatabase\Operations\JoinTypeEnum::newLeftJoin()
                );
        }

        throw new Exception('join type not found '.$joinType);
    }

    public function toDomain() : Domain\Models\JoinOperation
    {
        return Domain\Models\JoinOperation::new($this->foreignTableName, $this->foreignFields, $this->joinExpression, $this->joinType);
    }
}