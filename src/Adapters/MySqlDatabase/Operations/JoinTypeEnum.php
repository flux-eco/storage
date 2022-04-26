<?php

namespace FluxEco\Storage\Adapters\MySqlDatabase\Operations;
use FluxEco\Storage\Core\Ports;
use Laminas\Db\Sql\Join;

class JoinTypeEnum implements Ports\Database\Models\JoinTypeEnum
{
    private const JOIN_TYPE_INNER_JOIN = 'innerJoin';
    private string $joinType;

    private function __construct(string $joinType) {
        $this->joinType = $joinType;
    }

    public static function newInnerJoin() : self
    {
        return new self(self::JOIN_TYPE_INNER_JOIN);
    }

    public function getAdaptedJoinType() : string
    {
        switch($this->joinType) {
            case self::JOIN_TYPE_INNER_JOIN:
                return Join::JOIN_INNER;
                break;
        }
    }
}