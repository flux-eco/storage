<?php


namespace FluxEco\Storage\Adapters\MySqlDatabase\Builders;

use FluxEco\Storage\Adapters\MySqlDatabase\TableAdapter;
use FluxEco\Storage\Core\Ports;


interface TableBuilder extends Ports\Database\Builders\TableBuilder
{
    public function build(): TableAdapter;
}