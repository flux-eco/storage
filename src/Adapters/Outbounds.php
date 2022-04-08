<?php

namespace FluxEco\Storage\Adapters;

use FluxEco\Storage\Adapters;
use FluxEco\Storage\Core\Ports;

class Outbounds implements Ports\Outbounds
{
    private Ports\Config $config;

    private function __construct(Ports\Config $config)
    {
        $this->config = $config;
    }

    public static function new(
        Ports\Config $config
    ) : self {
        return new self($config);
    }

    public function getConfig() : Ports\Config
    {
        return $this->config;
    }


    public function getDatabaseClient() : Ports\Database\DatabaseClient
    {
        return $this->config->getDatabaseClient();
    }
}