<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase\Factories;

use FluxEco\Storage\Core\Domain\Models;
use FluxEco\Storage\Core\Ports;
use Laminas\Db\Sql\Ddl\Column;

class DdlColumnFactory
{

    private function __construct()
    {

    }

    public static function new(): self
    {
        return new self();
    }

    public function createDdlColumnfromStorageColumn(Ports\Database\Models\Column $column): Column\Column
    {
        switch (get_class($column)) {
            case Models\BooleanColumn::class:
                return new Column\Boolean($column->getName());
            case Models\DataTimeColumn::class:
                return new Column\Datetime($column->getName());
            case Models\FloatingColumn::class:
                $laminasColumn = new Column\Floating($column->getName());
                $laminasColumn->setNullable($column->isNullable());
                return $laminasColumn;
            case Models\IntegerColumn::class:
                return new Column\Integer($column->getName(), $column->isNullable());
            case Models\TextColumn::class:
                return new Column\Text($column->getName(), 0, $column->isNullable());
            case Models\VarcharColumn::class:
                return new Column\Varchar($column->getName(), 255, $column->isNullable());
        }
    }
}