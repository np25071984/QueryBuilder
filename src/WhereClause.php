<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

use np25071984\QueryBuilder\ConditionClause;

class WhereClause
{
        /** @var OperatorInterface[] $columns */
        private $conditions = [];

        public function __construct(array|ConditionClause $value) {
            // TODO: validate input; it is either a single ConditionClause or array of OperatorInterfaces
            switch (true) {
                case is_array($value):
                    foreach($value as $val) {
                        $this->conditions[] = $val;
                    }
                    break;
                case $value instanceof ConditionClause:
                    $this->conditions[] = $value;
                    break;
            }
        }

        public function getConditions(): array
        {
            return $this->conditions;
        }

        // public function toSql(): string
        // {
        //     $conditions = [];
        //     foreach($this->conditions as $tbl) {
        //         $conditions[] = $tbl->toSql();
        //     }

        //     return "WHERE " . implode(" AND ", $conditions);
        // }
}