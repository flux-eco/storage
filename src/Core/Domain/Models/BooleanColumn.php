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

    /**
     * @param Ports\Database\TableAsserters[] $columnNameAsserters
     */
    public static function new(string $name, array $columnNameAsserters = [], bool $nullable = false): self
    {
        if (count($columnNameAsserters) > 0) {
            foreach ($columnNameAsserters as $columnNameAsserter) {
                $columnNameAsserter->assertColumnNameIsLowerThanMaxLength($name);
            }
        }
        return new self($name, $nullable);
    }

    public function getName(): string
    {
        return $this->name;
    }
}