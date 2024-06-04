<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class SelectClause
{
    /** @var ColumnClause[]|Query[] $columns */
    private $columns;

    public function __construct(string|array|Column|Query $value) {
        // TODO: validate input
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->columns = array_map([$this, "processInputItem"], $value);
    }

    private function processInputItem(string|Column|Query $value): Column|Query
    {
        switch (true) {
            case is_string($value):
                return new Column($value);
            case $value instanceof Column:
            case $value instanceof Query:
                return $value;
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}