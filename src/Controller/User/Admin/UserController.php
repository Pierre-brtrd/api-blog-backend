<?php

namespace App\Controller\User\Admin;

use App\Dto\User\UpdateAdminUpdateRequest;
use App\Dto\User\UserFilterDto;
use App\Entity\User;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'User')]
#[Route('/api/admin/users', name: 'api_admin_users')]
#[Security(name: 'Bearer')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserMapper $userMapper,
    ) {
    }

    #[OA\Get(
        summary: 'Get all users',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Users retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(
                            type: User::class,
                            groups: ['user:read', 'common:read']
                        )
                    ),
                )
            ),
        ],
    )]
    #[Route('', name: '_list', methods: ['GET'])]
    public function list(
        #[MapQueryString]
        UserFilterDto $filtersDto,
    ): JsonResponse {
        return $this->json(
            $this->userRepository->findPaginate($filtersDto),
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read', 'common:read']]
        );
    }

    #[OA\Get(
        summary: 'Get a user by ID',
        responses: [
            new OA\Response(
                response: 200,
                description: 'User retrieved successfully',
                content: new OA\JsonContent(
                    ref: new Model(
                        type: User::class,
                        groups: ['user:read', 'common:read']
                    )
                )
            ),
        ],
    )]
    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json(
                ['message' => 'User not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read', 'common:read']]
        );
    }

    #[OA\Patch(
        summary: 'Update a user by ID',
        responses: [
            new OA\Response(
                response: 200,
                description: 'User updated successfully',
                content: new OA\JsonContent(
                    ref: new Model(
                        type: User::class,
                        groups: ['user:read', 'common:read']
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            ),
        ],
    )]
    #[Route('/{id}', name: '_update', methods: ['PATCH'])]
    public function update(
        #[MapRequestPayload]
        UpdateAdminUpdateRequest $dto,
        ?User $user,
    ): JsonResponse {
        if (!$user) {
            return $this->json(
                ['message' => 'User not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        $user = $this->userMapper->map($dto, $user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read', 'common:read']]
        );
    }

    #[OA\Delete(
        summary: 'Delete a user by ID',
        responses: [
            new OA\Response(
                response: 204,
                description: 'User deleted successfully'
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            ),
        ],
    )]
    #[Route('/{id}', name: '_delete', methods: ['DELETE'])]
    public function delete(?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json(
                ['message' => 'User not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(
            ['message' => 'User deleted successfully'],
            Response::HTTP_NO_CONTENT
        );
    }
}