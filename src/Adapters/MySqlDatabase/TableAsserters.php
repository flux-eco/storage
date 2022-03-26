<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase;

use FluxEco\Storage\Core\Ports;
use RuntimeException;

class TableAsserters implements Ports\Database\TableAsserters
{
    const MYSQL_COLUMN_NAME_MAX_LENGTH = 64;

    private function __construct()
    {

    }

    public static function new(): self
    {
        return new self();
    }

    public function assertColumnNameIsLowerThanMaxLength(string $columName): void
    {
        if (strlen($columName) > self::MYSQL_COLUMN_NAME_MAX_LENGTH) {
            throw new RuntimeException('Column name ' . $columName . ' has more than ' . self::MYSQL_COLUMN_NAME_MAX_LENGTH . ' characters');
        }
    }
}