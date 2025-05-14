<?php

namespace App\Dto\Article;

interface ArticleRequestInterface
{
    public function getTitle(): ?string;
    public function getContent(): ?string;
    public function getShortContent(): ?string;
    public function getUserId(): ?int;
    public function isEnabled(): ?bool;
}