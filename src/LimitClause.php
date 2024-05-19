<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class LimitClause
{
    public function __construct(
        public int $limit,
        public ?int $offset = 0,
    ) {
    }
}