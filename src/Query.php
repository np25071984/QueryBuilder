<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class Query
{
    private SelectClause $selectClause;
    private FromClause $fromClause;
    private ?WhereClause $whereClause = null;

    public function __construct(
        readonly public ?string $alias = null,
    ) {
    }

    public function select(SelectClause $selectClause): self
    {
        $this->selectClause = $selectClause;
        return $this;
    }

    public function from(FromClause $fromClause): self
    {
        $this->fromClause = $fromClause;
        return $this;
    }

    public function where(WhereClause $whereClause): self
    {
        $this->whereClause = $whereClause;
        return $this;
    }

    public function toSql(): string
    {
        $select = $this->selectClause->toSql();
        $from = $this->fromClause->toSql();
        if (is_null($this->whereClause)) {
            return $select . " " . $from;
        }
        $where = $this->whereClause->toSql();
        return $select . " " . $from . " " . $where;
    }
}