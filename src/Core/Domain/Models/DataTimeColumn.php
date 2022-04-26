<?php

namespace FluxEco\Storage\Core\Domain\Models;

use FluxEco\Storage\Core\{Domain\Asserters, Ports};

class DataTimeColumn implements Ports\Database\Models\Column
{
    private string $name;
    private bool $initWithZeroValues;

    private function __construct(string $name, bool $initWithZeroValues)
    {
        $this->name = $name;
        $this->initWithZeroValues = $initWithZeroValues;
    }


    public static function new(string $name, bool $initWithZeroValues = false): self
    {
        return new self($name, $initWithZeroValues);
    }

    public function getName(): string
    {
        return $this->name;
    }

    final public function isInitWithZeroValues(): bool
    {
        return $this->initWithZeroValues;
    }


}