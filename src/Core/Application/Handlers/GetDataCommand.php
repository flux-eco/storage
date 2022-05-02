<?php

namespace FluxEco\Storage\Core\Application\Handlers;

use FluxEco\Storage\Core\Domain;

class GetDataCommand implements Command
{

    private ?Domain\Models\Filter $filter;
    private ?int $sequenceOffSet;
    private ?int $limit;
    private ?string $orderBy;
    private ?string $search;
    private ?int $fromSeq;
    /** @var ?Domain\Models\JoinOperation[] */
    private ?array $joinOperationModels;

    private function __construct(
        ?Domain\Models\Filter $filter = null,
        ?int $sequenceOffSet = null,
        ?int $limit = null,
        ?string $orderBy = null,
        ?string $search = null,
        ?int $fromSeq = null,
        ?array $joinOperationModels = null
    ) {
        $this->filter = $filter;
        $this->sequenceOffSet = $sequenceOffSet;
        $this->limit = $limit;
        $this->orderBy = $orderBy;
        $this->search = $search;
        $this->fromSeq = $fromSeq;
        $this->joinOperationModels = $joinOperationModels;
    }

    /**
     * @param ?Domain\Models\JoinOperation[] $joinOperationModels
     */
    public static function new(
        ?Domain\Models\Filter $filter = null,
        ?int $sequenceOffSet = null,
        ?int $limit = null,
        ?string $orderBy = null,
        ?string $search = null,
        ?int $fromSeq = null,
        ?array $joinOperationModels = null
    ) : self {
        return new self($filter, $sequenceOffSet, $limit, $orderBy, $search, $fromSeq, $joinOperationModels);
    }

    final public function getFilter() : ?Domain\Models\Filter
    {
        return $this->filter;
    }

    final public function getLimit() : ?int
    {
        return $this->limit;
    }

    final public function getOrderBy() : ?string
    {
        return $this->orderBy;
    }

    public function getSearch() : ?string
    {
        return $this->search;
    }

    public function getSequenceOffSet() : ?int
    {
        return $this->sequenceOffSet;
    }

    public function getFromSeq() : ?int
    {
        return $this->fromSeq;
    }


    /**
     * @return ?Domain\Models\JoinOperation[]
     */
    public function getJoinOperationModels() : ?array
    {
        return $this->joinOperationModels;
    }

}