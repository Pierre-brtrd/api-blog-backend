<?php

namespace App\Controller;

use App\Dto\RegistrationRequest;
use App\Mapper\UserMapper;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Auth')]
#[OA\Post(
    path: '/api/register',
    summary: 'Register a new user',
    responses: [
        new OA\Response(
            response: 201,
            description: 'User registered successfully',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
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
    ],
)]
#[Route('/api', name: "api")]
final class RegisterController extends AbstractController
{
    #[Route('/register', name: '_registration', methods: ['POST'])]
    public function index(
        #[MapRequestPayload]
        RegistrationRequest $dto,
        EntityManagerInterface $em,
        UserMapper $userMapper,
    ): JsonResponse {
        $user = $userMapper->map($dto, null);

        $em->persist($user);
        $em->flush();

        return $this->json(
            ['id' => $user->getId()],
            Response::HTTP_CREATED
        );
    }
}
