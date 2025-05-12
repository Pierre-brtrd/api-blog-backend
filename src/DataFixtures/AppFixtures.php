<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();
        $userAdmin
            ->setUsername('admin')
            ->setFirstName('Admin')
            ->setLastName('User')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $userAdmin,
                    'admin'
                )
            );

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
