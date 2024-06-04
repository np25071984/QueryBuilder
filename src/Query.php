<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder;

use np25071984\QueryBuilder\Enums\QueryTypeEnum;

/**
 * TODO: make it immutable; once the value is set it shouldn't allow to rewrite it
 * (offer to create a new instance)
 */
class Query
{
    private QueryTypeEnum $type;
    private ?SelectClause $selectClause = null;
    private ?UpdateClause $updateClause = null;
    private ?DeleteClause $deleteClause = null;
    private ?FromClause $fromClause = null;
    private ?WhereClause $whereClause = null;
    private ?OrderByClause $orderByClause = null;
    private ?LimitClause $limitClause = null;
    private ?string $alias = null;

    public function select(SelectClause $clause): self
    {
        $this->selectClause = $clause;
        $this->type = QueryTypeEnum::SELECT;
        return $this;
    }

    public function getSelectClause(): ?SelectClause
    {
        return $this->selectClause;
    }

    public function update(UpdateClause $clause): self
    {
        $this->updateClause = $clause;
        $this->type = QueryTypeEnum::UPDATE;
        return $this;
    }

    public function getUpdateClause(): ?UpdateClause
    {
        return $this->updateClause;
    }

    public function delete(DeleteClause $clause): self
    {
        $this->deleteClause = $clause;
        $this->type = QueryTypeEnum::DELETE;
        return $this;
    }

    public function getDeleteClause(): ?DeleteClause
    {
        return $this->deleteClause;
    }

    public function from(FromClause $clause): self
    {
        $this->fromClause = $clause;
        return $this;
    }

    public function getFromClause(): ?FromClause
    {
        return $this->fromClause;
    }

    public function where(WhereClause $clause): self
    {
        $this->whereClause = $clause;
        return $this;
    }

    public function getWhereClause(): ?WhereClause
    {
        return $this->whereClause;
    }

    public function orderBy(OrderByClause $clause): self
    {
        $this->orderByClause = $clause;
        return $this;
    }

    public function getOrderByClause(): ?OrderByClause
    {
        return $this->orderByClause;
    }

    public function limit(LimitClause $clause): self
    {
        $this->limitClause = $clause;
        return $this;
    }

    public function getLimitClause(): ?LimitClause
    {
        return $this->limitClause;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function getType(): QueryTypeEnum
    {
        return $this->type;
    }
}