<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

readonly class ColumnClause
{
    public function __construct(
        public string $name,
        public ?string $alias = null,
    ) {
    }

    // public function toSql(): string
    // {
    //     if (is_null($this->alias)) {
    //         return $this->name;
    //     } else {
    //         return "{$this->name} AS {$this->alias}";
    //     }
    // }
}