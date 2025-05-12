<?php

namespace App\Controller\Article\Admin;

use App\Dto\Article\CreateArticleRequest;
use App\Entity\Article;
use App\Mapper\ArticleMapper;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Article')]
#[Route('/api/admin/article', name: 'api_article')]
final class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly EntityManagerInterface $em,
        private readonly ArticleMapper $articleMapper,
    ) {
    }

    #[OA\Get(
        summary: 'Get all articles',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Articles found',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(
                            type: Article::class,
                            groups: ['article:index', 'common:read']
                        )
                    )
                ),
            ),
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('', name: '_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->articleRepository->findAll(),
            Response::HTTP_OK,
            [],
            ['groups' => ['article:index', 'common:read']]
        );
    }


    #[OA\Post(
        summary: 'Create an article',
        responses: [
            new OA\Response(
                response: 201,
                description: 'Article created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                    ],
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'stattus', type: 'int'),
                        new OA\Property(property: 'detail', type: 'string'),
                    ],
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'title', type: 'string', example: 'Validation Error'),
                        new OA\Property(property: 'detail', type: 'string'),
                        new OA\Property(property: 'status', type: 'number', example: 422),
                        new OA\Property(property: 'violations', type: 'array', items: new OA\Items(
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'propertyPath', type: 'string'),
                                new OA\Property(property: 'title', type: 'string'),
                            ],
                        )),
                    ],
                ),
            ),
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('', name: '_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload()]
        CreateArticleRequest $dto,
    ): JsonResponse {
        $article = $this->articleMapper->map($dto, null);

        $this->em->persist($article);
        $this->em->flush();

        return $this->json(['id' => $article->getId()], Response::HTTP_CREATED);
    }
}
