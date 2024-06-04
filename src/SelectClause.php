<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class SelectClause
{
    /** @var ColumnClause|Query[] $columns */
    private $columns = [];

    public function __construct(string|array|Column|Query $value) {
        // TODO: validate input
        switch (true) {
            case is_string($value):
                $this->columns[] = new Column($value);
                break;
            case is_array($value):
                foreach($value as $val) {
                    switch (true) {
                        case is_string($value):
                            $this->columns[] = new Column($value);
                            break;
                        case $val instanceof Column:
                            $this->columns[] = $val;
                            break;
                        case $val instanceof Query:
                            $this->columns[] = $val;
                            break;
                    }
                }
                break;
            case $value instanceof Column:
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