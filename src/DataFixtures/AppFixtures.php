<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        // Ajout du ROLE_ADMIN en base
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        // Ajout d'un utilisateur avec le ROLE_ADMIN
        $adminUser = new User();
        $adminUser
            ->setFirstName('Laurent')
            ->setLastName('PICHON')
            ->setEmail('laurent@symfony.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->addUserRole($adminRole)
        ;

        $manager->persist($adminUser);

        for ($i = 1; $i <= 50; $i++) {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, 'password');

            $user
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setHash($hash)
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
