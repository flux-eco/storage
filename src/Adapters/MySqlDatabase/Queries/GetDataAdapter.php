<?php

namespace FluxEco\Storage\Adapters\MySqlDatabase\Queries;

use FluxEco\Storage\Core\Application;

class GetDataAdapter
{
    private int $limit;
    private array $filter;

    private function __construct(array $filter, int $limit = 0)
    {
        $this->limit = $limit;
        $this->filter = $filter;
    }

    public static function fromApplicationQuery(Application\Handlers\GetDataCommand $getListQuery): self
    {
        return new self($getListQuery->getFilter());
    }

    final public function toFilter(): array
    {
        return $this->filter;
    }

    public function toArray(): array
    {
        return $this->filter;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}