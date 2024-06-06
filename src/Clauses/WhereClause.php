<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Clauses;

use np25071984\QueryBuilder\Conditions\ConditionInterface;

class WhereClause
{
        /** @var OperatorInterface[] $columns */
        private $conditions = [];

        public function __construct(array|ConditionInterface $value) {
            // TODO: validate input; it is either a single ConditionClause or array of OperatorInterfaces
            switch (true) {
                case is_array($value):
                    foreach($value as $val) {
                        $this->conditions[] = $val;
                    }
                    break;
                case $value instanceof ConditionInterface:
                    $this->conditions[] = $value;
                    break;
            }
        }

        public function getConditions(): array
        {
            return $this->conditions;
        }
}