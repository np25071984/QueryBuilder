<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class FromClause
{
    /** @var TableClause[] $columns */
    private $tables = [];

    public function __construct(string|array|TableClause $value) {
        // TODO: validate input
        switch (true) {
            case is_string($value):
                $this->tables[] = new TableClause($value);
                break;
            case is_array($value):
                foreach($value as $val) {
                    switch (true) {
                        case is_string($value):
                            $this->tables[] = new TableClause($value);
                            break;
                        case $val instanceof TableClause:
                            $this->tables[] = $val;
                            break;
                    }
                }
                break;
            case $value instanceof TableClause:
                $this->tables[] = $value;
                break;
        }
    }

    public function getTables(): array
    {
        return $this->tables;
    }
}