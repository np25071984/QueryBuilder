<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Operators;

use np25071984\QueryBuilder\ConditionClause;;

readonly class OperatorOr implements OperatorInterface
{
    public function __construct(
        public ConditionClause|OperatorInterface $conditionClauseLeft,
        public ConditionClause|OperatorInterface $conditionClauseRight,
    ) {
    }

    // public function toSql(): string
    // {
    //     $left = $this->conditionClauseLeft->toSql();
    //     if (!($this->conditionClauseLeft instanceof ConditionClause)) {
    //         $left = "{$left}";
    //     }

    //     $right = $this->conditionClauseRight->toSql();
    //     if (!($this->conditionClauseRight instanceof ConditionClause)) {
    //         $right = "({$right})";
    //     }

    //     return "{$left} OR {$right}";
    // }
}