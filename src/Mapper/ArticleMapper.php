<?php

namespace App\Mapper;

use App\Dto\Article\ArticleRequestInterface;
use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleMapper
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function map(ArticleRequestInterface $dto, ?Article $article): Article
    {
        $article ??= new Article();

        if (null !== $dto->getTitle()) {
            $article->setTitle($dto->getTitle());
        }

        if (null !== $dto->getContent()) {
            $article->setContent($dto->getContent());
        }

        if (null !== $dto->getShortContent()) {
            $article->setShortContent($dto->getShortContent());
        }

        if (null !== $dto->isEnabled()) {
            $article->setEnabled($dto->isEnabled());
        }

        if (null !== $dto->getUserId()) {
            $user = $this->userRepository->find($dto->getUserId());

            if (null === $user) {
                throw new NotFoundHttpException('User not found');
            }

            $article->setUser($user);
        }

        return $article;
    }
}