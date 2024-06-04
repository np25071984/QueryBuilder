<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Enums;

enum QueryTypeEnum: string
{
    case SELECT = "SELECT";
    case UPDATE = "UPDATE";
    case INSERT = "INSERT";
    case DELETE = "DELETE";
}