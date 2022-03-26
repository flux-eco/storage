<?php

namespace FluxEco\Storage\Core\Application\Factories;

use FluxEco\Storage\Adapters\MySqlDatabase\TableAsserters;
use FluxEco\Storage\Core\{Domain\Models, Ports};

class ColumnFactory
{
    private const COLUMN_TYPE_TEXT = 'text';

    private const TYPE_STRING = 'string';
    private const TYPE_NUMBER = 'number';
    private const TYPE_INTEGER = 'integer';
    private const TYPE_ARRAY = 'array';
    private const TYPE_OBJECT = 'object';
    private const TYPE_BOOLEAN = 'boolean';

    private array $tableAsserters = [];

    private function __construct(TableAsserters $tableAsserters)
    {
        //  $this->tableAsserters = $tableAsserters;
    }


    public static function new(TableAsserters $columnNameAsserters): self
    {
        return new self($columnNameAsserters);
    }

    public function createColumnFromSchema(string $name, array $jsonValueSchema): Ports\Database\Models\Column
    {
        $nullable = false;
        if (array_key_exists('nullable', $jsonValueSchema)) {
            $nullable = $jsonValueSchema['nullable'];
        }

        if(key_exists('columnType',$jsonValueSchema)) {
            switch ($jsonValueSchema['columnType']) {
                case self::COLUMN_TYPE_TEXT:
                    return Models\TextColumn::new($name, $this->tableAsserters, $nullable);
            }
        }


        switch ($jsonValueSchema['type']) {
            case self::TYPE_STRING:
                return Models\VarcharColumn::new($name, $this->tableAsserters, $nullable);
            case self::TYPE_ARRAY:
            case self::TYPE_OBJECT:
                return Models\TextColumn::new($name, $this->tableAsserters, $nullable);
            case self::TYPE_BOOLEAN:
                return Models\BooleanColumn::new($name, $this->tableAsserters);
            case self::TYPE_NUMBER:
                return Models\FloatingColumn::new($name, $this->tableAsserters, $nullable);
            case self::TYPE_INTEGER:
                return Models\IntegerColumn::new($name, $this->tableAsserters, $nullable);
        }

        throw new \RuntimeException('Could not map json schema type ' . $jsonValueSchema['type'] . ' to a column type');
    }

}