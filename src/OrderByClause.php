<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

use np25071984\QueryBuilder\OrderColumnClause;

class OrderByClause
{
    /** @var OrderColumnClause[]|Query[] $columns */
    private $columns;

    public function __construct(string|array|Order|Query $value) {
        // TODO: validate input
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->columns = array_map([$this, "processInputItem"], $value);
    }

    private function processInputItem(string|Order|Query $value): Order|Query
    {
        switch (true) {
            case is_string($value):
                return new Order($value); // TODO: parse ASC/DESC
            case $value instanceof Order:
            case $value instanceof Query:
                return $value;
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}