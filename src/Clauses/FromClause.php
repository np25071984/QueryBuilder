<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Clauses;

use np25071984\QueryBuilder\Queries\AbstractQuery;
use np25071984\QueryBuilder\Primitives\Table;

class FromClause
{
    /** @var TableClause[] $columns */
    private $tables;

    public function __construct(string|array|Table $value) {
        // TODO: validate input

        if (!is_array($value)) {
            $value = [$value];
        }

        $this->tables = array_map([$this, "processInputItem"], $value);
    }

    private function processInputItem(string|Table|AbstractQuery $value): Table|AbstractQuery
    {
        if (is_string($value)) {
            return new Table($value);
        }

        return $value;
    }

    public function getTables(): array
    {
        return $this->tables;
    }
}