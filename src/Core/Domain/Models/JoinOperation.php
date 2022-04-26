<?php

namespace FluxEco\Storage\Core\Domain\Models;
use FluxEco\Storage\Core\Ports;

class JoinOperation
{
    private string $foreignTableName;
    private string $joinExpression;
    private Ports\Database\Models\JoinTypeEnum $joinType;


    private function __construct(string $foreignTableName, string $joinExpression, Ports\Database\Models\JoinTypeEnum $joinType)
    {
        $this->foreignTableName = $foreignTableName;
        $this->joinExpression = $joinExpression;
        $this->joinType = $joinType;
    }

    public static function new(string $foreignTableName, string $joinExpression, Ports\Database\Models\JoinTypeEnum $joinType): self
    {
        return new self($foreignTableName, $joinExpression, $joinType);
    }

    public function getForeignTableName() : string
    {
        return $this->foreignTableName;
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