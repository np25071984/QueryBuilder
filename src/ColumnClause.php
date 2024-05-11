<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class ColumnClause
{
    public function __construct(
        private string $name, // TODO: another object; (SELECT name FROM table) AS table_name
        private ?string $alias = null,
    ) {
    }

    public function toSql(): string
    {
        if (is_null($this->alias)) {
            return $this->name;
        } else {
            return "{$this->name} AS {$this->alias}";
        }
    }
}