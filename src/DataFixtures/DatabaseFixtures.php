<?php

namespace App\DataFixtures;

use App\User\Application\UseCase\StoreUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class DatabaseFixtures extends Fixture
{
    private $faker;

    public function __construct(
        private StoreUser $storeUser,
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
            $userData = [
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
            ];
        }

        $this->storeUser->execute($userData);

        echo "({$userData['email']}) created." . PHP_EOL;
    }
}