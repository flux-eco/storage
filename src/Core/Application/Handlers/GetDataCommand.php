<?php
namespace FluxEco\Storage\Core\Application\Handlers;

class GetDataCommand implements Command
{

    private array $filter;
    private int $limit;
    private ?string $orderBy;

    private function __construct(array $filter, int $limit = 0, ?string $orderBy = null)
    {
        $this->filter = $filter;
        $this->limit = $limit;
        $this->orderBy = $orderBy;
    }

    public static function new(array $filter, int $limit = 0,  ?string $orderBy = null): self
    {
        return new self($filter, $limit = 0, $orderBy);
    }


    final public function getFilter(): array
    {
        return $this->filter;
    }

    final public function getLimit(): int
    {
        return $this->limit;
    }

    final public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }


    public function jsonSerialize(): array
    {
        return [
            'filter' => $this->filter,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy
        ];
    }
}