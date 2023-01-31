<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USERS = [
        [
            'email' => 'admin@aol.com',
            'pseudo' => 'GIFMasta',
            'role' => ['ROLE_ADMIN'],
            'password' => 'admin123+',
        ],
        [
            'email' => 'm.scott@aol.com',
            'pseudo' => 'MichaelScarn',
            'role' => ['ROLE_USER'],
            'password' => 'scott123+',
        ],
        [
            'email' => 'r.howard@aol.com',
            'pseudo' => 'TheTemp',
            'role' => ['ROLE_USER'],
            'password' => 'howard123+',
        ],
        [
            'email' => 'd.schrute@aol.com',
            'pseudo' => 'Perfectenschlag',
            'role' => ['ROLE_USER'],
            'password' => 'schrute123+',
        ],
        [
            'email' => 'j.halpert@aol.com',
            'pseudo' => 'BigTuna',
            'role' => ['ROLE_USER'],
            'password' => 'scott123+',
        ],
        [
            'email' => 'a.bernard@aol.com',
            'pseudo' => 'NardDog',
            'role' => ['ROLE_USER'],
            'password' => 'bernard123+',
        ],
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $nbGif = count(GifFixtures::GIFS);

        foreach (self::USERS as $key => $values) {
            $user = new User();
            $user->setEmail($values['email']);
            $user->setRoles($values['role']);
            $user->setPseudo($values['pseudo']);
            $hash = $this->passwordHasher->hashPassword($user, $values['password']);
            $user->setPassword($hash);
            for ($i = 0; $i < $faker->numberBetween(4, 10); $i++) {
                $user->addToVotes($this->getReference('gif_' . $faker->numberBetween(0, $nbGif - 1)));
            }
            for ($i = 0; $i < $faker->numberBetween(3, 25); $i++) {
                $user->addToCollection($this->getReference('gif_' . $faker->numberBetween(0, $nbGif - 1)));
            }
            $manager->persist($user);
            $this->addReference('user_' . $key, $user);
        }
        $manager->flush();
    }
}
