<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class TableClause
{
    public function __construct(
        private string|Query $table, // TODO: another object; (SELECT name FROM table) AS table_name
        private ?string $alias = null,
    ) {
        // TODO: add validation; the $alias is mandatory for QueryB
    }

    public function toSql(): string
    {
        if ($this->table instanceof Query) {
            return "({$this->table->toSql()}) {$this->table->alias}";
        }

        if (is_null($this->alias)) {
            return $this->table;
        }

        return "{$this->table} {$this->alias}";
    }
}