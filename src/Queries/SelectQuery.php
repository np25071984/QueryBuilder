<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Queries;

use np25071984\QueryBuilder\Clauses\OrderByClause;
use np25071984\QueryBuilder\Clauses\LimitClause;
use np25071984\QueryBuilder\Clauses\SelectClause;
use np25071984\QueryBuilder\Clauses\FromClause;
use np25071984\QueryBuilder\Clauses\WhereClause;

class SelectQuery extends AbstractQuery
{
    private ?FromClause $fromClause = null;
    private ?WhereClause $whereClause = null;
    private ?OrderByClause $orderByClause = null;
    private ?LimitClause $limitClause = null;

    public function __construct(
        private SelectClause $selectClause
    ) {
    }

    public function getSelectClause(): ?SelectClause
    {
        return $this->selectClause;
    }

    public function from(FromClause $clause): self
    {
        $this->fromClause = $clause;
        return $this;
    }

    public function getFromClause(): ?FromClause
    {
        return $this->fromClause;
    }

    public function where(WhereClause $clause): self
    {
        $this->whereClause = $clause;
        return $this;
    }

    public function getWhereClause(): ?WhereClause
    {
        return $this->whereClause;
    }

    public function orderBy(OrderByClause $clause): self
    {
        $this->orderByClause = $clause;
        return $this;
    }

    public function getOrderByClause(): ?OrderByClause
    {
        return $this->orderByClause;
    }

    public function limit(LimitClause $clause): self
    {
        $this->limitClause = $clause;
        return $this;
    }

    public function getLimitClause(): ?LimitClause
    {
        return $this->limitClause;
    }
}