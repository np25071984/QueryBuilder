<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

use np25071984\QueryBuilder\Enums\OrderTypeEnum;

readonly class Order
{
    public function __construct(
        public string $column,
        public ?OrderTypeEnum $orderType = null,
    ) {
    }
}