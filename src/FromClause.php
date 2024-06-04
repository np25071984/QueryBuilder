<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class FromClause
{
    /** @var TableClause[] $columns */
    private $tables = [];

    public function __construct(string|array|Table $value) {
        // TODO: validate input
        switch (true) {
            case is_string($value):
                $this->tables[] = new Table($value);
                break;
            case is_array($value):
                foreach($value as $val) {
                    switch (true) {
                        case is_string($value):
                            $this->tables[] = new Table($value);
                            break;
                        case $val instanceof Table:
                            $this->tables[] = $val;
                            break;
                    }
                }
                break;
            case $value instanceof Table:
                $this->tables[] = $value;
                break;
        }
    }

    public function getTables(): array
    {
        return $this->tables;
    }
}