<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserFilterDto
{
    public function __construct(
        #[Assert\Positive]
        private readonly int $page = 1,
        #[Assert\Positive]
        private readonly int $limit = 6,

        private readonly ?string $search = null,

        private readonly ?string $sort = null,

        #[Assert\Choice(choices: ['ASC', 'DESC'])]
        private readonly ?string $order = null,
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): static
    {
        $this->search = $search;

        return $this;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(?string $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(?string $order): static
    {
        $this->order = $order;

        return $this;
    }
}