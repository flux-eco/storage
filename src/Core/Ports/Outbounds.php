<?php

namespace FluxEco\Storage\Core\Ports;

use FluxEco\Storage\Core\Ports;

interface Outbounds
{
    public function getConfig(): Config;

    public function getDatabaseClient(): Ports\Database\DatabaseClient;
}