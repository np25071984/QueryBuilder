<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Primitives;

readonly class Table
{
    public function __construct(
        public string $table,
        public ?string $alias = null,
    ) {
        // TODO: add validation; the $alias is mandatory for QueryB
    }
}