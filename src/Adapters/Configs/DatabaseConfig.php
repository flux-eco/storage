<?php

namespace FluxEco\Storage\Adapters\Configs;
use Flux\Eco;
use function getenv;

class DatabaseConfig
{

    private string $database;
    private string $driver;
    private string $host;
    private string $password;
    private string $username;

    private function __construct(
        string $database,
        string $driver,
        string $host,
        string $password,
        string $username
    )
    {
        $this->database = $database;
        $this->driver = $driver;
        $this->host = $host;
        $this->password = $password;
        $this->username = $username;
    }

    public static function fromEnvironmentVariables(string $upperCasePrefix): self
    {
        return new self(
            getenv($upperCasePrefix . '_MYSQL_DATABASE'),
            getenv($upperCasePrefix . '_MYSQL_DRIVER'),
            getenv($upperCasePrefix . '_MYSQL_HOST'),
            getenv($upperCasePrefix . '_MYSQL_PASSWORD'),
            getenv($upperCasePrefix . '_MYSQL_USER'),
        );
    }

    final public function getDatabase(): string
    {
        return $this->database;
    }

    final public function getDriver(): string
    {
        return $this->driver;
    }

    final public function getHost(): string
    {
        return $this->host;
    }

    final public function getPassword(): string
    {
        return $this->password;
    }

    final public function getUsername(): string
    {
        return $this->username;
    }

    final public function toArray(): array
    {
        return get_object_vars($this);
    }

    final public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}