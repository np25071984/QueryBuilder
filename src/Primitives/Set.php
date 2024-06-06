<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Primitives;

use np25071984\QueryBuilder\Queries\AbstractQuery;

readonly class Set
{
    public function __construct(
        public string $column,
        public string|AbstractQuery $value,
    ) {
    }
}