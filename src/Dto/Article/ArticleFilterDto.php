<?php

namespace App\Dto\Article;

use Symfony\Component\Validator\Constraints\Positive;

class ArticleFilterDto
{
    public function __construct(
        #[Positive]
        private readonly int $page = 1,
        #[Positive]
        private readonly int $limit = 6,
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
}