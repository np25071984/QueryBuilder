<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Conditions;

readonly class ConditionEqual implements ConditionInterface
{
    public function __construct(
        public string $nameLeft,
        public string $nameRight,
    ) {
    }
}