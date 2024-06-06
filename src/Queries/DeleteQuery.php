<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Queries;

use np25071984\QueryBuilder\Clauses\DeleteClause;
use np25071984\QueryBuilder\Clauses\FromClause;
use np25071984\QueryBuilder\Clauses\WhereClause;

class DeleteQuery extends AbstractQuery
{
    private ?FromClause $fromClause = null;
    private ?WhereClause $whereClause = null;

    public function __construct(
        private DeleteClause $deleteClause
    ) {
    }

    public function getDeleteClause(): ?DeleteClause
    {
        return $this->deleteClause;
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
}