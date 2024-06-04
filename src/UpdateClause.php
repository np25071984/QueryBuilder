<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class UpdateClause
{
    /** @var SetClause[]|Query[] $updates */
    private $updates;

    public function __construct(array|Set|Query $value) {
        // TODO: validate input

        if (!is_array($value)) {
            $value = [$value];
        }

        $this->updates = $value;
    }

    public function getUpdates(): array
    {
        return $this->updates;
    }
}