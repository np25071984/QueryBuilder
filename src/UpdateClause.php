<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

class UpdateClause
{
    /** @var SetClause|Query[] $updates */
    private $updates = [];

    public function __construct(array|SetClause|Query $value) {
        // TODO: validate input
        switch (true) {
            case is_array($value):
                foreach($value as $val) {
                    switch (true) {
                        case $val instanceof SetClause:
                            $this->updates[] = $val;
                            break;
                        case $val instanceof Query:
                            $this->updates[] = $val;
                            break;
                    }
                }
                break;
            case $value instanceof SetClause:
                $this->updates[] = $value;
                break;
            case $value instanceof Query:
                $this->updates[] = $value;
                break;
        }
    }

    public function getUpdates(): array
    {
        return $this->updates;
    }
}