<?php

namespace FluxEco\Storage\Core\Ports\Database\Models;


interface JoinTypeEnum
{
    public static function newInnerJoin(): self;
    public function getAdaptedJoinType(): string;
}