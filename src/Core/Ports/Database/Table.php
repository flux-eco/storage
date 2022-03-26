<?php

namespace FluxEco\Storage\Core\Ports\Database;

use FluxEco\Storage\Core\Ports\Database\Models\Column;

interface Table
{
    public function getTableName(): string;

    public function getPrimaryKey(): string|null;
    /**
     * @return string[]
     */
    public function getUniqueKey(): array;

    /**
     * @return Column[]
     */
    public function getColumns(): array;
}