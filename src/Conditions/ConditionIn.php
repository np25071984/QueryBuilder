<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Conditions;

readonly class ConditionIn implements ConditionInterface
{
    public function __construct(
        public string $name,
        public array $values,
    ) {
        // TODO: validate all items of $values array are Stringable
    }
}