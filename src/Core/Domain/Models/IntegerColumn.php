<?php

namespace FluxEco\Storage\Core\Domain\Models;

use FluxEco\Storage\Core\{Domain\Asserters, Ports};

class IntegerColumn implements Ports\Database\Models\Column
{
    private string $name;
    private bool $nullable;

    private function __construct(string $name, bool $nullable)
    {
        $this->name = $name;
        $this->nullable = $nullable;
    }

    /**
     * @param Ports\Database\TableAsserters $tableAsserters
     */
    public static function new(string $name, array $tableAsserters = [], bool $nullable = false): self
    {
        return new self($name, $nullable);
    }

    public function getName(): string
    {
        return $this->name;
    }

    final public function isNullable(): bool
    {
        return $this->nullable;
    }

}