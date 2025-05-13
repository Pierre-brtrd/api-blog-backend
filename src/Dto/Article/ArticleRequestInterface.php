<?php

namespace App\Dto\Article;

use App\Entity\User;

interface ArticleRequestInterface
{
    public function getTitle(): ?string;
    public function getContent(): ?string;
    public function getUserId(): ?int;
    public function isEnabled(): ?bool;
}