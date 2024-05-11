<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class ConditionClause
{
    public function __construct(
        private string $name,
        private string $operator,
        private string $value,
    ) {
    }

    public function toSql(): string
    {
        return "{$this->name} {$this->operator} {$this->value}";
    }
}