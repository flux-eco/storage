<?php

namespace FluxEco\Storage\Core\Domain\Models;

use FluxEco\Storage\Core\{Ports};

class FloatingColumn implements Ports\Database\Models\Column
{
    private string $name;
    private bool $nullable;

    private function __construct(string $name, bool $nullable)
    {
        $this->name = $name;
        $this->nullable = $nullable;
    }

    /**
     * @param Ports\Database\TableAsserters[] $columnNameAsserters
     */
    public static function new(string $name, array $columnNameAsserters = [], bool $nullable = false): self
    {
        if (count($columnNameAsserters) > 0) {
            foreach ($columnNameAsserters as $columnNameAsserter) {
                $columnNameAsserter->assert($name);
            }
        }
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