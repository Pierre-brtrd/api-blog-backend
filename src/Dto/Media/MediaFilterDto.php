<?php

namespace App\Dto\Media;

use Symfony\Component\Validator\Constraints as Assert;

class MediaFilterDto
{
    public function __construct(
        #[Assert\Positive]
        private readonly int $page = 1,

        #[Assert\Positive]
        private readonly int $limit = 6,
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}