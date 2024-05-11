<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Operators;

interface OperatorInterface
{
    public function toSql(): string;
}