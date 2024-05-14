<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

readonly class TableClause
{
    public function __construct(
        public string $table,
        public ?string $alias = null,
    ) {
        // TODO: add validation; the $alias is mandatory for QueryB
    }
}