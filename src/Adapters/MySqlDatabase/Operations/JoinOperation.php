<?php

namespace FluxEco\Storage\Adapters\MySqlDatabase\Operations;
use FluxEco\Storage\Core\{Domain, Ports};

class JoinOperation
{
    private string $foreignTableName;
    private string $foreignFields;
    private string $joinExpression;
    private Ports\Database\Models\JoinTypeEnum $joinType;


    private function __construct(string $foreignTableName, string $foreignFields, string $joinExpression, Ports\Database\Models\JoinTypeEnum $joinType) {
        $this->foreignTableName = $foreignTableName;
        $this->foreignFields = $foreignFields;
        $this->joinExpression = $joinExpression;
        $this->joinType = $joinType;
    }

    public static function fromDomain(Domain\Models\JoinOperation $joinOperation) : self
    {
        return new self($joinOperation->getForeignTableName(), $joinOperation->getForeignFields(), $joinOperation->getJoinExpression(), $joinOperation->getJoinType());
    }

    public function getForeignTableName() : string
    {
        return $this->foreignTableName;
    }


    public function getForeignFields() : string
    {
        return $this->foreignFields;
    }


    public function getJoinExpression() : string
    {
        return $this->joinExpression;
    }

    public function getJoinType() : Ports\Database\Models\JoinTypeEnum
    {
        return $this->joinType;
    }
}