<?php

namespace App\Dto\Article;

use App\Entity\User;

interface ArticleRequestInterface
{
    public function getTitle(): ?string;
    public function getContent(): ?string;
    public function getUser(): ?User;
}