<?php

namespace FluxEco\Storage\Core\Domain\Models;

use FluxEco\Storage\Core\{Ports};

class BooleanColumn implements Ports\Database\Models\Column
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function new(string $name): self
    {
        return new self($name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}