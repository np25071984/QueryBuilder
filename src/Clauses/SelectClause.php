<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Clauses;

use np25071984\QueryBuilder\Queries\AbstractQuery;
use np25071984\QueryBuilder\Primitives\Column;

class SelectClause
{
    /** @var ColumnClause[]|Query[] $columns */
    private $columns;

    public function __construct(string|array|Column|AbstractQuery $value) {
        // TODO: validate input
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->columns = array_map([$this, "processInputItem"], $value);
    }

    private function processInputItem(string|Column|AbstractQuery $value): Column|AbstractQuery
    {
        switch (true) {
            case is_string($value):
                return new Column($value);
            case $value instanceof Column:
            case $value instanceof AbstractQuery:
                return $value;
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}