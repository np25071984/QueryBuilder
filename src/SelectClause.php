<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

use RuntimeException;

class SelectClause
{
    /** @var ColumnClause[] $columns */
    private $columns = [];

    public function __construct(string|array|ColumnClause|Query $value) {
        // TODO: validate input
        switch (true) {
            case is_string($value):
                $this->columns[] = new ColumnClause($value);
                break;
            case is_array($value):
                foreach($value as $val) {
                    switch (true) {
                        case is_string($value):
                            $this->columns[] = new ColumnClause($value);
                            break;
                        case $val instanceof ColumnClause:
                            $this->columns[] = $val;
                            break;
                        case $val instanceof Query:
                            $this->columns[] = new ColumnClause("({$val->toSql()})", $val->alias);
                            break;
                    }
                }
                break;
            case $value instanceof ColumnClause:
                $this->columns[] = $value;
                break;
            case $value instanceof Query:
                $this->columns[] = new ColumnClause("({$value->toSql()})", "aaa");
                break;
            }

    }

    public function toSql(): string
    {
        /**
         * TODO: implementation should be part of a driver (injected as Strategy design pattern)
         * MySQL, PostreSQL, Oracle, etc drivers
         */
        $columns = [];
        foreach($this->columns as $col) {
            $columns[] = $col->toSql();
        }

        return "SELECT " . implode(", ", $columns);
    }
}