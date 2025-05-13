<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->faker = Factory::create('fr_FR');
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
                    'Test1234!'
                )
            );

        $users[] = $userAdmin;
        for($i = 1; $i <= 10; $i++) {
            $user = (new User);

            $user
                ->setUsername("user-$i")
                ->setFirstName($this->faker->unique()->firstName())
                ->setLastName($this->faker->unique()->lastName())
                ->setPassword(
                    $this->passwordHasher->hashPassword(
                        $user,
                        'Test1234!'
                    )
                );
            
            $users[] = $user;
            $manager->persist($user);
        }

        for ($i = 1; $i <=20; $i++) {
            $article = (new Article)
                ->setTitle($this->faker->words(2, true))
                ->setContent($this->faker->paragraph(3))
                ->setEnabled($this->faker->boolean())
                ->setUser($this->faker->randomElement($users))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeThisYear()));

            $manager->persist($article);
        }

        $manager->persist($userAdmin);

        $manager->flush();
    }
}
