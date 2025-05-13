<?php

namespace App\Controller\Article\Admin;

use App\Dto\Article\ArticleFilterDto;
use App\Dto\Article\CreateArticleRequest;
use App\Dto\Article\UpdateArticleRequest;
use App\Entity\Article;
use App\Mapper\ArticleMapper;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Image;

#[OA\Tag(name: 'Article')]
#[Route('/api/admin/articles', name: 'api_article')]
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
    public function index(
        #[MapQueryString]
        ArticleFilterDto $filterDto,
    ): JsonResponse {
        $articles = $this->articleRepository->findPaginate($filterDto);

        $total = $this->articleRepository->countAll();
        $pages = ceil($total / $filterDto->getLimit());

        $data = [
            'items' => $articles,
            'meta' => [
                'total' => $total,
                'page' => $filterDto->getPage(),
                'limit' => $filterDto->getLimit(),
                'pages' => $pages,
            ]
        ];

        return $this->json(
            $data,
            Response::HTTP_OK,
            [],
            ['groups' => ['article:index', 'common:read']]
        );
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(?Article $article): JsonResponse
    {
        if (!$article) {
            return $this->json(['detail' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($article, Response::HTTP_OK, [], [
            'groups' => ['article:index', 'common:read'],
        ]);
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

    #[OA\Patch(
        summary: 'Update an article',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Article updated',
                content: new OA\JsonContent(
                    ref: new Model(
                        type: Article::class,
                        groups: ['article:index', 'common:read']
                    )
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Article not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'int'),
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
    #[Route('/{id}', name: '_update', methods: ['PATCH'])]
    public function update(
        #[MapRequestPayload()]
        UpdateArticleRequest $dto,
        Article $article
    ): JsonResponse {
        $this->articleMapper->map($dto, $article);

        $this->em->flush();

        return $this->json($article, Response::HTTP_OK, [], [
            'groups' => ['article:index', 'common:read'],
        ]);
    }

    #[OA\Delete(
        summary: 'Delete an article',
        responses: [
            new OA\Response(
                response: 204,
                description: 'Article deleted',
            ),
            new OA\Response(
                response: 404,
                description: 'Article not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'int'),
                        new OA\Property(property: 'detail', type: 'string'),
                    ],
                ),
            ),
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('/{id}', name: '_delete', methods: ['DELETE'])]
    public function delete(Article $article): JsonResponse
    {
        $this->em->remove($article);
        $this->em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}/upload', name: '_upload', methods: ['POST'])]
    public function uploadFile(
        Article $article,
        #[MapUploadedFile([
            new Image(
                maxSize: '8M',
                maxSizeMessage: 'The image is too large. Maximum size is {{ limit }} {{ suffix }}.',
                mimeTypes: [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp',
                    'image/svg+xml',
                ],
                detectCorrupted: true,
            ),
        ]
        )]
        UploadedFile $image
    ): JsonResponse {
        $article->setImageFile($image);

        $this->em->persist($article);
        $this->em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}/switch', name: '_switch', methods: ['GET'])]
    public function swicth(?Article $article): JsonResponse
    {
        if (!$article) {
            return $this->json(['detail' => 'Aritcle non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $article->setEnabled(!$article->isEnabled());

        $this->em->flush();

        return $this->json($article, Response::HTTP_OK, [], [
            'groups' => ['article:index', 'common:read'],
        ]);
    }
}
