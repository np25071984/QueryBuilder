<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Queries;

use np25071984\QueryBuilder\Clauses\UpdateClause;
use np25071984\QueryBuilder\Clauses\WhereClause;

class UpdateQuery extends AbstractQuery
{
    private ?WhereClause $whereClause = null;

    public function __construct(
        private UpdateClause $updateClause
    ) {
    }

    public function getUpdateClause(): ?UpdateClause
    {
        return $this->updateClause;
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