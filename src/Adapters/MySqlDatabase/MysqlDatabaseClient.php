<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase;

use FluxEco\Storage\Adapters\Configs\Config;
use FluxEco\Storage\Adapters\MySqlDatabase\Commands;
use FluxEco\Storage\Adapters\MySqlDatabase\Factories\DdlColumnFactory;
use FluxEco\Storage\Core\Application\Handlers;
use FluxEco\Storage\Core\Ports;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Ddl\{Column, Constraint, CreateTable, DropTable};
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;
use Swoole\Database\PDOConfig;

class MysqlDatabaseClient implements Ports\Database\DatabaseClient
{
    protected static array $instances = [];

    private DatabaseConfig $databaseConfig;
    private Adapter $dbAdapter;
    private Sql $sql;
    private TableGateway $tableGateway;
    private array $jsonSchema;

    private function __construct(DatabaseConfig $databaseConfig, Adapter $dbAdapter, Sql $sql, TableGateway $tableGateway, array $jsonSchema)
    {
        $this->databaseConfig = $databaseConfig;
        $this->dbAdapter = $dbAdapter;
        $this->sql = $sql;
        $this->tableGateway = $tableGateway;
        $this->jsonSchema = $jsonSchema;
    }

    public static function new(
        string         $tableName,
        array          $jsonSchema,
        DatabaseConfig $databaseConfig
    ): self
    {
        $databaseName = $databaseConfig->getDatabase();

        if (empty(static::$instances[$databaseName]) === true || empty(static::$instances[$databaseName][$tableName]) === true) {
            $dbAdapter = new Adapter($databaseConfig->toArray());
            $tableGateway = new TableGateway($tableName, $dbAdapter);
            $sql = new Sql($dbAdapter, $tableName);
            static::$instances[$databaseName][$tableName] = new self($databaseConfig, $dbAdapter, $sql, $tableGateway, $jsonSchema);
        }

        return static::$instances[$databaseName][$tableName];
    }

    final public function deleteData(array $filter): void
    {
        $this->tableGateway->delete($filter);
    }

    final public function getData(Handlers\GetDataCommand $getDataCommand): array
    {
        $sequenceOffSet = $getDataCommand->getSequenceOffSet();
        $limit = $getDataCommand->getLimit();
        $filter = $getDataCommand->getFilter();
        $orderby = $getDataCommand->getOrderBy();

        $result = iterator_to_array($this->tableGateway->select(function (Select $select) use ($filter, $sequenceOffSet, $limit, $orderby) {

            if (count($filter) > 0) {
                foreach ($filter as $key => $value) {
                    $select->where->equalTo($key, $value);
                }
            }

            if ($orderby !== null) {
                $select->order($orderby);
            }

            if ($sequenceOffSet > 0) {
                $select->offset($sequenceOffSet);
            }

            if ($limit > 0) {
                $select->limit($limit);
            }
        }));
        $rows = [];
        foreach ($result as $row) {
            $rows[] = iterator_to_array($row);
        }
        return $rows;
    }

    final public function countData(Handlers\CountDataCommand $countDataCommand): int
    {
        $limit = $countDataCommand->getLimit();
        $filter = $countDataCommand->getFilter();
        //todo limit, and columns
        return $this->tableGateway->select($filter)->count();
    }


    final public function updateData(Handlers\UpdateDataCommand $updateDataCommand): void
    {
        $storeDataAdapter = Commands\StoreDataAdapter::fromApplicationCommand($this->jsonSchema, $updateDataCommand);
        $this->tableGateway->update($storeDataAdapter->getData(), $storeDataAdapter->getFilter());
    }


    final public function appendData(Handlers\AppendDataCommand $appendDataCommand): void
    {
        $appendDataAdapter = Commands\StoreDataAdapter::fromApplicationCommand($this->jsonSchema, $appendDataCommand);
        $this->tableGateway->insert($appendDataAdapter->getData());
    }

    final public function createStorage(Handlers\CreateStorageCommand $createStorageCommand): void
    {
        $ddlColumnFactory = DdlColumnFactory::new();
        $createStorageAdapter = Commands\CreateStorageAdapter::fromApplicationCommmand($createStorageCommand, $ddlColumnFactory);
        $sql = $this->sql;

        $databaseName = $this->databaseConfig->getDatabase();
        $dbAdapter = $this->dbAdapter;


        $tableName = $createStorageAdapter->getTableName();


        $columns = $createStorageAdapter->getDdlColumns();
        $hasUniqueKey = $createStorageAdapter->hasUniqueKey();
        $uniqueKey = $createStorageAdapter->getUniqueKey();

        $primaryKey = $createStorageAdapter->getPrimaryKey();

        //guard
        $this->assertTableNotExists($dbAdapter, $databaseName, $tableName);


        $table = new CreateTable($tableName);
        $this->addColumns($columns, $table);

        if ($primaryKey !== null) {
            $table->addConstraint(new Constraint\PrimaryKey($primaryKey));
        }

        if ($hasUniqueKey === true) {
            $table->addConstraint(new Constraint\UniqueKey($uniqueKey));
        }
        $dbAdapter->query($sql->buildSqlString($table), $dbAdapter::QUERY_MODE_EXECUTE);
    }

    public function deleteStorage(string $tableName) : void
    {
        $dbAdapter = $this->dbAdapter;
        $sql = $this->sql;
        $dropTable = new DropTable($tableName);
        $dbAdapter->query($sql->buildSqlString($dropTable), $dbAdapter::QUERY_MODE_EXECUTE);
    }

    /** @param Column\Column[] $columns */
    private function addColumns(array $columns, CreateTable $table): void
    {
        foreach ($columns as $column) {
            $table->addColumn($column);
        }
    }

    final public function storageExists(Handlers\StorageExistsCommand $storageExistsCommand): bool
    {
        $dataBaseName = $this->databaseConfig->getDatabase();
        $tableName = $storageExistsCommand->getTableName();
        $dbAdapter = $this->dbAdapter;

        $query = "SELECT * FROM information_schema.tables WHERE table_schema = '" . $dataBaseName . "' AND table_name = '" . $tableName . "' LIMIT 1;";
        $result = $dbAdapter->query($query, $dbAdapter::QUERY_MODE_EXECUTE)->toArray();
        if (!empty($result[0])) {
            return true;
        }
        return false;
    }

    final public function getJsonSchema(): array
    {
        return $this->jsonSchema;
    }


    /**
     * @throws \Exception
     */
    private function assertTableNotExists(Adapter $adapter, string $dataBaseName, string $tableName): void
    {
        /*
        $query = "SELECT * FROM information_schema.tables WHERE table_schema = '" . $dataBaseName . "' AND table_name = '" . $tableName . "' LIMIT 1;";
        $result = $adapter->query($query, $adapter::QUERY_MODE_EXECUTE)->toArray();

        if (!empty($result[0])) {
            throw new \RuntimeException('Table ' . $tableName . ' already exists');
        }*/
    }


}