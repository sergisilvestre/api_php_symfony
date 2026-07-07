<?php

namespace App\DataFixtures;

use App\User\Application\UseCase\StoreUser;
use App\User\Infrastructure\Doctrine\Entity\UserRecord;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class DatabaseFixtures extends Fixture
{
    private $faker;

    public function __construct(
        private StoreUser $storeUser,
        private EntityManagerInterface $entityManager,
    ) {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        echo "Seeding database..." . PHP_EOL;

        $this->createUser([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
        ]);

        for ($i = 0; $i < 10; $i++) {
            $this->createUser();
        }
    }

    private function createUser(?array $userData = null): void
    {
        echo "Creating user... ";

        if ($userData === null) {
            do {
                $email = $this->faker->safeEmail();

                $exists = $this->entityManager
                    ->getRepository(UserRecord::class)
                    ->findOneBy(['email' => $email]);

            } while ($exists !== null);

            $userData = [
                'name' => $this->faker->name(),
                'email' => $email,
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
            ];
        }

        $this->storeUser->execute($userData);

        echo "({$userData['email']}) created." . PHP_EOL;
    }
}