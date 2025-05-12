<?php

namespace App\Controller;

use App\Dto\RegistrationRequest;
use App\Mapper\UserMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

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
