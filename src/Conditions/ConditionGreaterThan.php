<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Conditions;

readonly class ConditionGreaterThan implements ConditionInterface
{
    public function __construct(
        public string $name,
        public mixed $value,
    ) {
    }
}