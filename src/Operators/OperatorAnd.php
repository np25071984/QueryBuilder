<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Operators;

use np25071984\QueryBuilder\ConditionClause;

readonly class OperatorAnd implements OperatorInterface
{
    public function __construct(
        public ConditionClause|OperatorInterface $conditionClauseLeft,
        public ConditionClause|OperatorInterface $conditionClauseRight,
    ) {
    }
}