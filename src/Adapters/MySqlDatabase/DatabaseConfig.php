<?php

namespace FluxEco\Storage\Adapters\MySqlDatabase;

use Flux\Eco;
use function getenv;
use FluxEco\Storage\Core\Ports;

class DatabaseConfig implements Ports\Database\DatabaseConfig
{
    private string $hostname;
    private string $driver;
    private string $database;
    private string $password;
    private string $username;
    private string $plattform;

    private function __construct(
        string $hostname,
        string $driver,
        string $database,
        string $username,
        string $password
    ) {
        $this->hostname = $hostname;
        $this->driver = $driver;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->plattform = 'Mysql';
    }

    public static function new(
        string $hostname,
        string $driver,
        string $database,
        string $username,
        string $password,
    ) : self
    {
        return new self(
            $hostname,
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

    final public function getHostname() : string
    {
        return $this->hostname;
    }

    final public function getPassword() : string
    {
        return $this->password;
    }

    final public function getUsername() : string
    {
        return $this->username;
    }

    public function getPlattform() : string
    {
        return $this->plattform;
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