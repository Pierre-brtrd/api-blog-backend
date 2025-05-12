<?php

namespace App\Controller\User;

use App\Dto\User\UpdateProfileRequest;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'User')]
#[Route('/api/profile', name: 'api_profile')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em,
        private readonly UserMapper $userMapper,
    ) {
    }

    #[OA\Get(
        summary: 'Get user profile',
        responses: [
            new OA\Response(
                response: 200,
                description: 'User profile retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'username', type: 'string'),
                        new OA\Property(property: 'firstName', type: 'string'),
                        new OA\Property(property: 'lastName', type: 'string'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'updatedAt', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'fullName', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'code', type: 'number', example: 401),
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            ),
        ]
    )]
    #[Route('', name: '', methods: ['GET'])]
    public function getProfile(): JsonResponse
    {
        return $this->json(
            $this->getUser(),
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read', 'common:read']]
        );
    }

    #[OA\Patch(
        summary: 'Update user profile',
        responses: [
            new OA\Response(
                response: 200,
                description: 'User profile updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'username', type: 'string'),
                        new OA\Property(property: 'firstName', type: 'string'),
                        new OA\Property(property: 'lastName', type: 'string'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'updatedAt', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'fullName', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Invalid input',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'title', type: 'string', example: 'Validation Error'),
                        new OA\Property(property: 'detail', type: 'string'),
                        new OA\Property(property: 'status', type: 'number', example: 422),
                        new OA\Property(property: 'violations', type: 'array', items: new OA\Items(type: 'object', properties: [
                            new OA\Property(property: 'propertyPath', type: 'string'),
                            new OA\Property(property: 'title', type: 'string'),
                        ])),
                    ]
                )
            ),
        ]
    )]
    #[Route('/update', name: '_update', methods: ['PATCH'])]
    public function updateProfile(
        #[MapRequestPayload]
        UpdateProfileRequest $dto,
    ): JsonResponse {
        $user = $this->getUser();

        $this->userMapper->map($dto, $user);

        $this->em->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read', 'common:read']]
        );
    }
}