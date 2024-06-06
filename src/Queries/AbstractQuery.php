<?php

declare(strict_types=1);

namespace np25071984\QueryBuilder\Queries;

abstract class AbstractQuery
{
    protected ?string $alias = null;

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }
}