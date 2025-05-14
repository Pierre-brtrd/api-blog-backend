<?php

namespace App\Controller\Article\Frontend;

use App\Dto\Article\ArticleFilterDto;
use App\Entity\User;
use App\Repository\ArticleRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[OA\Tag(name: 'Article - Front')]
#[Route('/api/articles', name: 'api_article')]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
    }

    #[OA\Get(
        summary: 'Get a list of articles',
        description: 'Get a list of articles',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of articles',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/Article'
                    )
                )
            ),
        ],
    )]
    #[Route('', name: '_index', methods: ['GET'])]
    public function index(
        #[MapQueryString]
        ArticleFilterDto $articleFilterDto
    ): JsonResponse {
        return $this->json(
            $this->articleRepository->findPaginate($articleFilterDto, false)
            ,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['article:index', 'common:read'],
            ]
        );
    }

    #[OA\Get(
        summary: 'Get a list of articles by user',
        description: 'Get a list of articles by user',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of articles by user',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/Article'
                    )
                )
            ),
        ],
    )]
    #[Route('/user/{id}', name: '_index_by_user', methods: ['GET'])]
    public function indexByUser(
        #[MapQueryString]
        ArticleFilterDto $articleFilterDto,
        ?User $user = null
    ): JsonResponse {
        return $this->json(
            $this->articleRepository->findPaginateByUser($articleFilterDto, $user, false)
            ,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['article:index:user', 'common:read'],
            ]
        );
    }
}