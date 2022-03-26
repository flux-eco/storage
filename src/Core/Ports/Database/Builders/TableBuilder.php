<?php

namespace FluxEco\Storage\Core\Ports\Database\Builders;

use FluxEco\Storage\Core\Ports\Database\Table;

interface TableBuilder
{
    public function addColumnFromSchema(string $name, array $jsonValueSchema);

    public function addVarcharColumn(string $name): \FluxEco\Storage\Core\Application\Builders\TableBuilder;

    public function addTextColumn(string $name): \FluxEco\Storage\Core\Application\Builders\TableBuilder;

    public function addIntegerColumn(string $name): \FluxEco\Storage\Core\Application\Builders\TableBuilder;

    public function addDataTimeColumnType(string $name): \FluxEco\Storage\Core\Application\Builders\TableBuilder;


    public function addPrimaryKey(string $columnName): \FluxEco\Storage\Core\Application\Builders\TableBuilder;

    /**
     * @param string[] $columnNames
     */
    public function addUniqueKey(array $columnNames): \FluxEco\Storage\Core\Application\Builders\TableBuilder;

    public function build(): Table;
}