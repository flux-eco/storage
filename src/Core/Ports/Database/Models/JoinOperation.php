<?php

namespace FluxEco\Storage\Core\Ports\Database\Models;

use FluxEco\Storage\Core\Domain;

interface JoinOperation
{
    public function toDomain() : Domain\Models\JoinOperation;
}