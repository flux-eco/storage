<?php

namespace FluxEco\Storage;

class Env
{
    public const STORAGE_HOST = 'STORAGE_HOST';
    public const STORAGE_DRIVER = 'STORAGE_DRIVER';
    public const STORAGE_NAME = 'STORAGE_NAME';
    public const STORAGE_USER = 'STORAGE_USER';
    public const STORAGE_PASSWORD = 'STORAGE_PASSWORD';

    private string $envPrefix;

    private function __construct(string $envPrefix)
    {
        $this->envPrefix = $envPrefix;
    }

    public static function new(string $envPrefix = '')
    {
        return new self($envPrefix);
    }

    public function getHost() : string
    {
        return getenv($this->envPrefix . self::STORAGE_HOST);
    }

    public function getDriver() : string
    {
        return getenv($this->envPrefix . self::STORAGE_DRIVER);
    }

    public function getName() : string
    {
        return getenv($this->envPrefix . self::STORAGE_NAME);
    }

    public function getUser() : string
    {
        return getenv($this->envPrefix . self::STORAGE_USER);
    }

    public function getPassword() : string
    {
        return getenv($this->envPrefix . self::STORAGE_PASSWORD);
    }
}