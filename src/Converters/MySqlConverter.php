<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Converters;

use np25071984\QueryBuilder\Query;
use np25071984\QueryBuilder\ColumnClause;
use np25071984\QueryBuilder\TableClause;
use np25071984\QueryBuilder\ConditionClause;
use np25071984\QueryBuilder\Operators\OperatorOr;
use np25071984\QueryBuilder\Operators\OperatorAnd;

class MySqlConverter
{
    public function convertToSql(Query $query): string
    {
        $sql = "";
        $columns = [];
        foreach ($query->selectClause->getColumns() as $column) {
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
        $sql .= "SELECT " . implode(", ", $columns);

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
        $sql .= " FROM " . implode(", ", $tables);

        if (!is_null($query->whereClause)) {
            $conditions = [];
            foreach ($query->whereClause->getConditions() as $condition) {
                switch(true) {
                    case $condition instanceof ConditionClause:
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

    private function processConditionClause(ConditionClause $condition): string
    {
        return "{$condition->name} {$condition->operator} {$condition->value}";
    }

    private function processOperatorOr(OperatorOr $operator): string
    {
        $leftClause = $operator->conditionClauseLeft;
        $rightClause = $operator->conditionClauseRight;

        switch (true) {
            case $leftClause instanceof OperatorOr:
                $left = "(" . $this->processOperatorOr($leftClause) . ")";
                break;
            case $leftClause instanceof OperatorAnd:
                $left = "(" . $this->processOperatorAnd($leftClause) . ")";
                break;
            case $leftClause instanceof ConditionClause:
                $left = "{$leftClause->name} {$leftClause->operator} {$leftClause->value}";
                break;
        }

        switch (true) {
            case $rightClause instanceof OperatorOr:
                $right = "(" . $this->processOperatorOr($rightClause) . ")";
                break;
            case $rightClause instanceof OperatorAnd:
                $right = "(" . $this->processOperatorAnd($rightClause) . ")";
                break;
            case $rightClause instanceof ConditionClause:
                $right = "{$rightClause->name} {$rightClause->operator} {$rightClause->value}";
                break;
        }

        return "{$left} OR {$right}";
    }

    private function processOperatorAnd(OperatorAnd $operator): string
    {
        $leftClause = $operator->conditionClauseLeft;
        $rightClause = $operator->conditionClauseRight;

        switch (true) {
            case $leftClause instanceof OperatorOr:
                $left = "(" . $this->processOperatorOr($leftClause) . ")";
                break;
            case $leftClause instanceof OperatorAnd:
                $left = "(" . $this->processOperatorAnd($leftClause) . ")";
                break;
            case $leftClause instanceof ConditionClause:
                $left = "{$leftClause->name} {$leftClause->operator} {$leftClause->value}";
                break;
        }

        switch (true) {
            case $rightClause instanceof OperatorOr:
                $right = "(" . $this->processOperatorOr($rightClause) . ")";
                break;
            case $rightClause instanceof OperatorAnd:
                $right = "(" . $this->processOperatorAnd($rightClause) . ")";
                break;
            case $rightClause instanceof ConditionClause:
                $right = "{$rightClause->name} {$rightClause->operator} {$rightClause->value}";
                break;
        }

        return "{$left} AND {$right}";
    }

}