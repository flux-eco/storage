<?php
namespace FluxEco\Storage\Core\Application\Handlers;

class CountDataCommand implements Command
{
    private array $filter;
    private int $limit;

    private function __construct(array $filter, int $limit = 0)
    {
        $this->filter = $filter;
        $this->limit = $limit;
    }

    public static function new(array $filter, int $limit = 0): self
    {
        return new self($filter, $limit = 0);
    }


    final public function getFilter(): array
    {
        return $this->filter;
    }

    final public function getLimit(): int
    {
        return $this->limit;
    }


    public function jsonSerialize(): array
    {
        return [
            'filter' => $this->filter,
            'limit' => $this->limit
        ];
    }
}