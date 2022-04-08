<?php


namespace FluxEco\Storage\Core\Application\Builders;

use FluxEco\Storage\Core\{Application\Factories\ColumnFactory, Domain\Models, Domain\Table, Ports};

class TableBuilder implements Ports\Database\Builders\TableBuilder
{
    private string $tableName;
    private ?string $primaryKey = null;
    /** @var string[] */
    private array $uniqueKey = [];
    private array $columns = [];
    private Ports\Database\TableAsserters $tableAsserters;
    private ColumnFactory $columnFactory;

    private function __construct(
        string                        $tableName,
        ColumnFactory                 $columnFactory
    )
    {
        $this->tableName = $tableName;
        $this->columnFactory = $columnFactory;
    }


    public static function new(string $tableName): self
    {
        $columnFactory = ColumnFactory::new();
        return new self($tableName, $columnFactory);
    }

    final public function addColumnFromSchema(string $name, array $jsonValueSchema): self
    {
        $this->columns[$name] = $this->columnFactory->createColumnFromSchema($name, $jsonValueSchema);
        return $this;
    }

    final public function addVarcharColumn(string $name): self
    {
        $this->columns[$name] = Models\VarcharColumn::new($name, $this->tableAsserters);
        return $this;
    }

    final  public function addTextColumn(string $name): self
    {
        $this->columns[$name] = Models\TextColumn::new($name, $this->tableAsserters);
        return $this;
    }

    final public function addIntegerColumn(string $name): self
    {
        $this->columns[$name] = Models\IntegerColumn::new($name, $this->tableAsserters);
        return $this;
    }

    final public function addDataTimeColumnType(string $name): self
    {
        $this->columns[$name] = Models\DataTimeColumn::new($name, $this->tableAsserters);
        return $this;
    }


    final public function addPrimaryKey(string $columnName): self
    {
        $this->primaryKey = $columnName;
        return $this;
    }

    /**
     * @param string[] $columnNames
     */
    final public function addUniqueKey(array $columnNames): self
    {
        $this->uniqueKey = $columnNames;
        return $this;
    }

    final public function build(): Ports\Database\Table
    {
        return Table::new(
            $this->tableName,
            $this->columns,
            $this->primaryKey,
            $this->uniqueKey
        );
    }

}