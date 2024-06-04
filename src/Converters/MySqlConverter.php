<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Converters;

use np25071984\QueryBuilder\Query;
use np25071984\QueryBuilder\Column;
use np25071984\QueryBuilder\Table;
use np25071984\QueryBuilder\Conditions\ConditionEqual;
use np25071984\QueryBuilder\Conditions\ConditionGreaterThan;
use np25071984\QueryBuilder\Conditions\ConditionIn;
use np25071984\QueryBuilder\Conditions\ConditionInterface;
use np25071984\QueryBuilder\Conditions\ConditionNull;
use np25071984\QueryBuilder\DeleteClause;
use np25071984\QueryBuilder\UpdateClause;
use np25071984\QueryBuilder\Operators\OperatorOr;
use np25071984\QueryBuilder\Operators\OperatorAnd;
use np25071984\QueryBuilder\Order;
use np25071984\QueryBuilder\SelectClause;
use np25071984\QueryBuilder\Enums\QueryTypeEnum;

class MySqlConverter
{
    public function convertToString(Query $query): string
    {
        $sql = "";

        $type = $query->getType();
        switch ($type) {
            case QueryTypeEnum::SELECT:
                $sql .= $this->processSelectClause($query->getSelectClause());
                break;
            case QueryTypeEnum::DELETE:
                $sql .= "DELETE";
                break;
            case QueryTypeEnum::UPDATE:
                $sql .= $this->processUpdateClause($query->getUpdateClause());
                break;
        }

        $tables = [];
        foreach ($query->getFromClause()->getTables() as $table) {
            switch (true) {
                case $table instanceof Table:
                    if (is_null($table->alias)) {
                        $tables[] = $table->table;
                    } else {
                        $tables[] = $table->table . " " . $table->alias;
                    }
                    break;
                case $table instanceof Query:
                    $subquerySql = $this->convertToString($table);
                    $tables[] = "(" . $subquerySql . ")  " . $table->getAlias();
                    break;
            }
        }
        $tablesStr = implode(", ", $tables);
        if ($type === QueryTypeEnum::UPDATE) {
            $sql = sprintf($sql, $tablesStr);
        } else {
            $sql .= " FROM {$tablesStr}";
        }

        $whereClause = $query->getWhereClause();
        if (!is_null($whereClause)) {
            $conditions = [];
            foreach ($whereClause->getConditions() as $condition) {
                switch(true) {
                    case $condition instanceof ConditionInterface:
                        $conditions[] = $this->processConditionClause($condition);
                        break;
                    case $condition instanceof OperatorOr:
                        $conditions[] = $this->processOperatorOr($condition);
                        break;
                    case $condition instanceof OperatorAnd:
                        $conditions[] = $this->processOperatorAnd($condition);
                        break;
                }
            }
            $sql .= " WHERE " . implode(" ", $conditions);
        }

        $orderByClause = $query->getOrderByClause();
        if (!is_null($orderByClause)) {
            $columns = [];
            foreach ($orderByClause->getColumns() as $column) {
                switch (true) {
                    case $column instanceof Order:
                        if (is_null($column->orderType)) {
                            $columns[] = $column->column;
                        } else {
                            $columns[] = $column->column . " " . $column->orderType->value;
                        }
                        break;
                    case $column instanceof Query:
                        $subquerySql = $this->convertToString($column);
                        $columns[] = "(" . $subquerySql . ") " . $column->getAlias();
                        break;
                }
            }
            $sql .= " ORDER BY " . implode(", ", $columns);
        }

        $limitClause = $query->getLimitClause();
        if (!is_null($limitClause)) {
            $sql .= " LIMIT " . $limitClause->limit;
            if ($limitClause->offset !== 0) {
                $sql .= " OFFSET " . $limitClause->offset;
            }
        }

        return $sql;
    }

    private function processSelectClause(SelectClause $clause): string
    {
        $columns = [];
        foreach ($clause->getColumns() as $column) {
            switch (true) {
                case $column instanceof Column:
                    if (is_null($column->alias)) {
                        $columns[] = $column->name;
                    } else {
                        $columns[] = $column->name . " AS " . $column->alias;
                    }
                    break;
                case $column instanceof Query:
                    $subquerySql = $this->convertToString($column);
                    $columns[] = "(" . $subquerySql . ") AS " . $column->getAlias();
                    break;
            }
        }
        return "SELECT " . implode(", ", $columns);
    }

    private function processUpdateClause(UpdateClause $clause): string
    {
        $updates = [];
        foreach ($clause->getUpdates() as $update) {
            switch (true) {
                case is_string($update->value):
                    $updates[] = "{$update->column} = {$update->value}";
                    break;
                case $update->value instanceof Query:
                    $subquerySql = $this->convertToString($update->value);
                    $updates[] = "{$update->column} = ({$subquerySql})";
                    break;
            }

        }
        return "UPDATE %s SET " . implode(", ", $updates);
    }

    private function processOperatorOr(OperatorOr $operator): string
    {
        $conditions = [];
        foreach ($operator->conditions as $condition) {
            switch (true) {
                case $condition instanceof OperatorOr:
                    $cond = "(" . $this->processOperatorOr($condition) . ")";
                    break;
                case $condition instanceof OperatorAnd:
                    $cond = "(" . $this->processOperatorAnd($condition) . ")";
                    break;
                case $condition instanceof ConditionInterface:
                    $cond = $this->processConditionClause($condition);
                    break;
            }
            $conditions[] = $cond;
        }

        return implode(" OR ", $conditions);
    }

    private function processOperatorAnd(OperatorAnd $operator): string
    {
        $conditions = [];
        foreach ($operator->conditions as $condition) {
            switch (true) {
                case $condition instanceof OperatorOr:
                    $cond = "(" . $this->processOperatorOr($condition) . ")";
                    break;
                case $condition instanceof OperatorAnd:
                    $cond = "(" . $this->processOperatorAnd($condition) . ")";
                    break;
                case $condition instanceof ConditionInterface:
                    $cond = $this->processConditionClause($condition);
                    break;
            }
            $conditions[] = $cond;
        }

        return implode(" AND ", $conditions);
    }

    private function processConditionClause(ConditionInterface $condition): string
    {
        switch (true) {
            case $condition instanceof ConditionIn:
                return sprintf("{$condition->name} IN (%s)", implode(", ", $condition->values));
                break;
            case $condition instanceof ConditionEqual:
                return "{$condition->nameLeft} = {$condition->nameRight}";
                break;
            case $condition instanceof ConditionGreaterThan:
                return "{$condition->name} > {$condition->value}";
                break;
            case $condition instanceof ConditionNull:
                return "{$condition->name} IS NULL";
                break;
            }
    }
}