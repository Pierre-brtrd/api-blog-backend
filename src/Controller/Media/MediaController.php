<?php

namespace App\Controller\Media;

use App\Dto\Media\MediaFilterDto;
use App\Entity\Media;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Image;

#[OA\Tag(name: 'Media')]
#[Route('/api/admin/medias', name: 'api_admin_media_')]
class MediaController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MediaRepository $mediaRepository,
    ) {
    }

    #[OA\Post(
        summary: 'Create a new media',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns the created media',
                content: new OA\JsonContent(

                    properties: [
                        new OA\Property(
                            property: 'id',
                            type: 'integer',
                            description: 'The ID of the media'
                        ),
                        new OA\Property(
                            property: 'mediaName',
                            type: 'string',
                            description: 'The name of the media'
                        ),
                        new OA\Property(
                            property: 'mediaSize',
                            type: 'integer',
                            description: 'The size of the media in bytes'
                        ),
                    ],
                )
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
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
        UploadedFile $media
    ): JsonResponse {
        $media = (new Media)
            ->setMediaFile($media);

        $this->em->persist($media);
        $this->em->flush();

        return $this->json([
            'id' => $media->getId(),
            'mediaName' => $media->getMediaName(),
            'mediaSize' => $media->getMediaSize(),
        ]);
    }

    #[OA\Get(
        summary: 'Get a list of media',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns a list of media',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(
                            type: Media::class,
                            groups: ['media:index', 'common:read']
                        )
                    )
                )
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(
        #[MapQueryString]
        MediaFilterDto $mediaFilterDto
    ): JsonResponse {
        return $this->json(
            $this->mediaRepository->findPaginate($mediaFilterDto),
            Response::HTTP_OK,
            [],
            [
                'groups' => ['media:index', 'common:read'],
            ]
        );
    }

    #[OA\Get(
        summary: 'Get a media by ID',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns the media',
                content: new OA\JsonContent(
                    ref: new Model(
                        type: Media::class,
                        groups: ['media:index', 'common:read']
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Media not found'
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(?Media $media): JsonResponse
    {
        if (!$media) {
            return $this->json(
                [
                    'message' => 'Media not found',
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            $media,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['media:index', 'common:read'],
            ]
        );
    }

    #[OA\Delete(
        summary: 'Delete a media',
        responses: [
            new OA\Response(
                response: 204,
                description: 'Media deleted'
            ),
            new OA\Response(
                response: 404,
                description: 'Media not found'
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(?Media $media): JsonResponse
    {
        if (!$media) {
            return $this->json(
                [
                    'message' => 'Media not found',
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $this->em->remove($media);
        $this->em->flush();

        return $this->json(
            [
                'message' => 'Media deleted',
            ],
            Response::HTTP_NO_CONTENT
        );
    }
}