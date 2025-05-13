<?php

namespace App\Controller\Article\Frontend;

use App\Dto\Article\ArticleFilterDto;
use App\Repository\ArticleRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

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
        $articles = $this->articleRepository->findPaginate($articleFilterDto, false);

        $total = $this->articleRepository->countAll(false);

        $data = [
            'items' => $articles,
            'meta' => [
                'total' => $total,
                'page' => $articleFilterDto->getPage(),
                'limit' => $articleFilterDto->getLimit(),
                'pages' => ceil($total / $articleFilterDto->getLimit()),
            ],
        ];

        return $this->json($data, Response::HTTP_OK, [], [
            'groups' => ['article:index', 'common:read'],
        ]);
    }
}