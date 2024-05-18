<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

readonly class Query
{
    public function __construct(
        public SelectClause|DeleteClause|UpdateClause $selectClause,
        public FromClause $fromClause,
        public ?WhereClause $whereClause = null,
        public ?OrderByClause $orderByClause = null,
        public ?string $alias = null,
    ) {
    }
}