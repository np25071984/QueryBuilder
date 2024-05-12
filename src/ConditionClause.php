<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

readonly class ConditionClause
{
    public function __construct(
        public string $name,
        public string $operator,
        public string $value,
    ) {
    }

    // public function toSql(): string
    // {
    //     return "{$this->name} {$this->operator} {$this->value}";
    // }
}