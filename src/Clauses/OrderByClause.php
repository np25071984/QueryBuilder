<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Clauses;

use np25071984\QueryBuilder\OrderColumnClause;
use np25071984\QueryBuilder\Queries\AbstractQuery;
use np25071984\QueryBuilder\Primitives\Order;

class OrderByClause
{
    /** @var OrderColumnClause[]|Query[] $columns */
    private $columns;

    public function __construct(string|array|Order|AbstractQuery $value) {
        // TODO: validate input
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->columns = array_map([$this, "processInputItem"], $value);
    }

    private function processInputItem(string|Order|AbstractQuery $value): Order|AbstractQuery
    {
        switch (true) {
            case is_string($value):
                return new Order($value); // TODO: parse ASC/DESC
            case $value instanceof Order:
            case $value instanceof AbstractQuery:
                return $value;
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}