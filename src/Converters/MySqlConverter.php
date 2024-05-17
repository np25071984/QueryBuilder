<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Converters;

use np25071984\QueryBuilder\Query;
use np25071984\QueryBuilder\ColumnClause;
use np25071984\QueryBuilder\TableClause;
use np25071984\QueryBuilder\ConditionClause;
use np25071984\QueryBuilder\Conditions\ConditionEqual;
use np25071984\QueryBuilder\Conditions\ConditionGreaterThan;
use np25071984\QueryBuilder\Conditions\ConditionIn;
use np25071984\QueryBuilder\Conditions\ConditionInterface;
use np25071984\QueryBuilder\Conditions\ConditionNull;
use np25071984\QueryBuilder\DeleteClause;
use np25071984\QueryBuilder\UpdateClause;
use np25071984\QueryBuilder\Operators\OperatorOr;
use np25071984\QueryBuilder\Operators\OperatorAnd;
use np25071984\QueryBuilder\SelectClause;

class MySqlConverter
{
    public function convertToSql(Query $query): string
    {
        $sql = "";

        switch (true) {
            case $query->selectClause instanceof SelectClause:
                $sql .= $this->processSelectClause($query->selectClause);
                break;
            case $query->selectClause instanceof DeleteClause:
                $sql .= "DELETE";
                break;
            case $query->selectClause instanceof UpdateClause:
                $sql .= $this->processUpdateClause($query->selectClause);
                break;
        }

        $tables = [];
        foreach ($query->fromClause->getTables() as $table) {
            switch (true) {
                case $table instanceof TableClause:
                    if (is_null($table->alias)) {
                        $tables[] = $table->table;
                    } else {
                        $tables[] = $table->table . " " . $table->alias;
                    }
                    break;
                case $table instanceof Query:
                    $tables[] = "(" . $table->toSql() . ")  " . $table->alias;
                    break;
            }
        }
        $tablesStr = implode(", ", $tables);
        if ($query->selectClause instanceof UpdateClause) {
            $sql = sprintf($sql, $tablesStr);
        } else {
            $sql .= " FROM {$tablesStr}";
        }

        if (!is_null($query->whereClause)) {
            $conditions = [];
            foreach ($query->whereClause->getConditions() as $condition) {
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

        return $sql;
    }

    private function processSelectClause(SelectClause $clause): string
    {
        $columns = [];
        foreach ($clause->getColumns() as $column) {
            switch (true) {
                case $column instanceof ColumnClause:
                    if (is_null($column->alias)) {
                        $columns[] = $column->name;
                    } else {
                        $columns[] = $column->name . " AS " . $column->alias;
                    }
                    break;
                case $column instanceof Query:
                    $columns[] = "(" . $column->toSql() . ") AS " . $column->alias;
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
                    $updates[] = "{$update->column} = ({$update->value->toSql()})";
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