<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase\Commands;

use FluxEco\Storage\Adapters\MySqlDatabase\Factories\DdlColumnFactory;
use FluxEco\Storage\Core\{Application};
use Laminas\Db\Sql\Ddl\Column\Column;

class CreateStorageAdapter
{
    private string $tableName;
    private ?string $primaryKey;
    private array $uniqueKey = [];
    /** @var Column[] */
    private array $ddlColumns;
    private array $indexes;


    /**
     * @param Column[] $ddlColumns
     */
    private function __construct(
        string $tableName,
        ?string  $primaryKey = null,
        array $uniqueKey,
        array  $ddlColumns,
        array $indexes
    )
    {
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
        $this->uniqueKey = $uniqueKey;
        $this->ddlColumns = $ddlColumns;
        $this->indexes = $indexes;
    }

    public static function fromApplicationCommmand(Application\Handlers\CreateStorageCommand $createStorageCommand, DdlColumnFactory $ddlColumnFactory): self
    {
        $storage = $createStorageCommand->getStorage();

        $tableName = $storage->getTableName();
        $primaryKey = $storage->getPrimaryKey();
        $uniqueKey = $storage->getUniqueKey();
        $storageColumns = $storage->getColumns();
        $indexes = $storage->getIndexes();
        $ddlColumns = [];
        foreach ($storageColumns as $storageColumn) {
            $ddlColumns[] = $ddlColumnFactory->createDdlColumnfromStorageColumn($storageColumn);
        }

        return new self(
            $tableName,
            $primaryKey,
            $uniqueKey,
            $ddlColumns,
            $indexes
        );
    }

    public function hasUniqueKey(): bool
    {
        return count($this->uniqueKey) > 0;
    }

    /**
     * @return string
     */
    final public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return Column[]
     */
    final public function getDdlColumns(): array
    {
        return $this->ddlColumns;
    }


    final public function getPrimaryKey(): string|null
    {
        return $this->primaryKey;
    }

    final public function getUniqueKey(): array
    {
        return $this->uniqueKey;
    }

    public function getIndexes() : array
    {
        return $this->indexes;
    }




}