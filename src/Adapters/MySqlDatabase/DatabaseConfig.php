<?php

namespace FluxEco\Storage\Adapters\MySqlDatabase;

use Flux\Eco;
use function getenv;
use FluxEco\Storage\Core\Ports;

class DatabaseConfig implements Ports\Database\DatabaseConfig
{
    private string $host;
    private string $driver;
    private string $database;
    private string $password;
    private string $username;

    private function __construct(
        string $host,
        string $driver,
        string $database,
        string $username,
        string $password
    ) {
        $this->host = $host;
        $this->driver = $driver;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public static function new(
        string $host,
        string $driver,
        string $database,
        string $username,
        string $password,
    ) : self
    {
        return new self(
            $host,
            $driver,
            $database,
            $username,
            $password
        );
    }

    final public function getDatabase() : string
    {
        return $this->database;
    }

    final public function getDriver() : string
    {
        return $this->driver;
    }

    final public function getHost() : string
    {
        return $this->host;
    }

    final public function getPassword() : string
    {
        return $this->password;
    }

    final public function getUsername() : string
    {
        return $this->username;
    }

    final public function toArray() : array
    {
        return get_object_vars($this);
    }

    final public function jsonSerialize() : array
    {
        return $this->toArray();
    }
}