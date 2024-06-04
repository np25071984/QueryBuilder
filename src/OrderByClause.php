<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

use np25071984\QueryBuilder\OrderColumnClause;

class OrderByClause
{
    /** @var OrderColumnClause|Query[] $columns */
    private $columns = [];

    public function __construct(string|array|Order|Query $value) {
        // TODO: validate input
        switch (true) {
            case is_string($value):
                $this->columns[] = new Order($value); // TODO: parse ASC/DESC
                break;
            case is_array($value):
                foreach($value as $val) {
                    switch (true) {
                        case is_string($value):
                            $this->columns[] = new Order($value);
                            break;
                        case $val instanceof Order:
                            $this->columns[] = $val;
                            break;
                        case $val instanceof Query:
                            $this->columns[] = $val;
                            break;
                    }
                }
                break;
            case $value instanceof Order:
                $this->columns[] = $value;
                break;
            case $value instanceof Query:
                $this->columns[] = $value;
                break;
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}