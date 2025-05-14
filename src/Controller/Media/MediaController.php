<?php

namespace App\Controller\Media;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Image;

#[OA\Tag(name: 'Media')]
#[Route('/api/admin/medias', name: 'api_admin_media_')]
class MediaController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

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
}