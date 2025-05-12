<?php

namespace App\Dto\Article;

use App\Entity\User;
use App\Validator\Constraints\UniqueTitle;
use Symfony\Component\Serializer\Attribute\Groups;
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
        #[Groups(['article:write'])]
        private readonly ?string $title = null,

        #[Assert\NotBlank(message: 'Le contenu est requis.')]
        #[Groups(['article:write'])]
        private readonly ?string $content = null,

        #[Groups(['article:write'])]
        private readonly ?bool $enabled = null,

        #[Assert\NotBlank(message: 'L\'utilisateur est requis.')]
        #[Groups(['article:write'])]
        private readonly ?int $userId = null,

        #[Groups(['article:write'])]
        private readonly ?bool $enbaled = null,
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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }
}