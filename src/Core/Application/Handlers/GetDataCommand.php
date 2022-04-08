<?php
namespace FluxEco\Storage\Core\Application\Handlers;

class GetDataCommand implements Command
{

    private array $filter;
    private int $sequenceOffSet;
    private int $limit;
    private ?string $orderBy;

    private function __construct(array $filter,  int $sequenceOffSet, int $limit = 0, ?string $orderBy = null)
    {
        $this->filter = $filter;
        $this->sequenceOffSet = $sequenceOffSet;
        $this->limit = $limit;
        $this->orderBy = $orderBy;
    }

    public static function new(array $filter, int $sequenceOffSet = 0, int $limit = 0,  ?string $orderBy = null): self
    {
        return new self($filter, $sequenceOffSet, $limit, $orderBy);
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

    public function getSequenceOffSet() : int
    {
        return $this->sequenceOffSet;
    }




    public function jsonSerialize(): array
    {
        return [
            'filter' => $this->filter,
            'sequenceOffSet' => $this->sequenceOffSet,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy
        ];
    }
}