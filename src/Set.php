<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

readonly class Set
{
    public function __construct(
        public string $column,
        public string|Query $value,
    ) {
    }
}