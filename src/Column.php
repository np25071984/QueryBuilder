<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

readonly class Column
{
    public function __construct(
        public string $name,
        public ?string $alias = null,
    ) {
    }
}