<?php

namespace FluxEco\Storage\Core\Ports;


interface Config
{
    public function getDatabaseName() : string;

    public function getTableName() : string;

    public function getJsonSchema() : array;

    public function getDatabaseClient() : Database\DatabaseClient;
}