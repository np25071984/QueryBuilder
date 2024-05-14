<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Operators;

use np25071984\QueryBuilder\ConditionClause;;

readonly class OperatorOr implements OperatorInterface
{
    public array $conditions;

    public function __construct(
        ConditionClause|OperatorInterface ...$conditions,
    ) {
        $this->conditions = $conditions;
    }
}