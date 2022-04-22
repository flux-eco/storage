<?php

namespace FluxEco\Storage\Core\Ports\Database;

interface DatabaseConfig
{
    public function getDatabase() : string;

    public function getDriver() : string;

    public function getHostname() : string;

    public function getPassword() : string;

    public function getUsername() : string;

    public function toArray() : array;

    public function jsonSerialize() : array;
}