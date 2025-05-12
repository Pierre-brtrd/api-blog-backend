<?php

namespace App\Dto\Article;

use App\Entity\User;
use App\Validator\Constraints\UniqueTitle;
use Symfony\Component\Validator\Constraints as Assert;

class CreateArticleRequest implements ArticleRequestInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le titre est requis.')]
        #[Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Le titre doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.'
        )]
        #[UniqueTitle('Le titre "{{ value }}" est déjà utilisé.')]
        private readonly ?string $title = null,

        #[Assert\NotBlank(message: 'Le contenu est requis.')]
        private readonly ?string $content = null,

        private readonly ?bool $enabled = null,

        #[Assert\NotBlank(message: 'L\'utilisateur est requis.')]
        private readonly ?User $user = null,
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}