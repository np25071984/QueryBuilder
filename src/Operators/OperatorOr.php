<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Operators;

use np25071984\QueryBuilder\Conditions\ConditionInterface;

readonly class OperatorOr implements OperatorInterface
{
    public array $conditions;

    public function __construct(
        ConditionInterface|OperatorInterface ...$conditions,
    ) {
        $this->conditions = $conditions;
    }
}